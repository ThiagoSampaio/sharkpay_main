<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Caster;

use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Casts Reflector related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
 */
class ReflectionCaster
{
    public const UNSET_CLOSURE_FILE_INFO = ['Closure' => __CLASS__.'::unsetClosureFileInfo'];

    private const EXTRA_MAP = [
        'docComment' => 'getDocComment',
        'extension' => 'getExtensionName',
        'isDisabled' => 'isDisabled',
        'isDeprecated' => 'isDeprecated',
        'isInternal' => 'isInternal',
        'isUserDefined' => 'isUserDefined',
        'isGenerator' => 'isGenerator',
        'isVariadic' => 'isVariadic',
    ];

    /**
     * @return array
     */
    public static function castClosure(\Closure $c, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $c = new \ReflectionFunction($c);

        $a = static::castFunctionAbstract($c, $a, $stub, $isNested, $filter);

        if (!str_contains($c->name, '{closure')) {
            $stub->class = isset($a[$prefix.'class']) ? $a[$prefix.'class']->value.'::'.$c->name : $c->name;
            unset($a[$prefix.'class']);
        }
        unset($a[$prefix.'extra']);

        $stub->class .= self::getSignature($a);

        if ($f = $c->getFileName()) {
            $stub->attr['file'] = $f;
            $stub->attr['line'] = $c->getStartLine();
        }

        unset($a[$prefix.'parameters']);

        if ($filter & Caster::EXCLUDE_VERBOSE) {
            $stub->cut += ($c->getFileName() ? 2 : 0) + \count($a);

            return [];
        }

        if ($f) {
            $a[$prefix.'file'] = new LinkStub($f, $c->getStartLine());
            $a[$prefix.'line'] = $c->getStartLine().' to '.$c->getEndLine();
        }

        return $a;
    }

    /**
     * @return array
     */
    public static function unsetClosureFileInfo(\Closure $c, array $a)
    {
        unset($a[Caster::PREFIX_VIRTUAL.'file'], $a[Caster::PREFIX_VIRTUAL.'line']);

        return $a;
    }

    public static function castGenerator(\Generator $c, array $a, Stub $stub, bool $isNested): array
    {
        // Cannot create ReflectionGenerator based on a terminated Generator
        try {
            $reflectionGenerator = new \ReflectionGenerator($c);

            return self::castReflectionGenerator($reflectionGenerator, $a, $stub, $isNested);
        } catch (\Exception) {
            $a[Caster::PREFIX_VIRTUAL.'closed'] = true;

            return $a;
        }
    }

    /**
     * @return array
     */
    public static function castType(\ReflectionType $c, array $a, Stub $stub, bool $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($c instanceof \ReflectionNamedType) {
            $a += [
                $prefix.'name' => $c instanceof \ReflectionNamedType ? $c->getName() : (string) $c,
                $prefix.'allowsNull' => $c->allowsNull(),
                $prefix.'isBuiltin' => $c->isBuiltin(),
            ];
        } elseif ($c instanceof \ReflectionUnionType || $c instanceof \ReflectionIntersectionType) {
            $a[$prefix.'allowsNull'] = $c->allowsNull();
            self::addMap($a, $c, [
                'types' => 'getTypes',
            ]);
        } else {
            $a[$prefix.'allowsNull'] = $c->allowsNull();
        }

        return $a;
    }

    /**
     * @return array
     */
    public static function castAttribute(\ReflectionAttribute $c, array $a, Stub $stub, bool $isNested)
    {
        $map = [
            'name' => 'getName',
            'arguments' => 'getArguments',
        ];

        if (\PHP_VERSION_ID >= 80400) {
            unset($map['name']);
        }

        self::addMap($a, $c, $map);

        return $a;
    }

    /**
     * @return array
     */
    public static function castReflectionGenerator(\ReflectionGenerator $c, array $a, Stub $stub, bool $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($c->getThis()) {
            $a[$prefix.'this'] = new CutStub($c->getThis());
        }
        $function = $c->getFunction();
        $frame = [
            'class' => $function->class ?? null,
            'type' => isset($function->class) ? ($function->isStatic() ? '::' : '->') : null,
            'function' => $function->name,
            'file' => $c->getExecutingFile(),
            'line' => $c->getExecutingLine(),
        ];
        if ($trace = $c->getTrace(\DEBUG_BACKTRACE_IGNORE_ARGS)) {
            $function = new \ReflectionGenerator($c->getExecutingGenerator());
            array_unshift($trace, [
                'function' => 'yield',
                'file' => $function->getExecutingFile(),
                'line' => $function->getExecutingLine(),
            ]);
            $trace[] = $frame;
            $a[$prefix.'trace'] = new TraceStub($trace, false, 0, -1, -1);
        } else {
            $function = new FrameStub($frame, false, true);
            $function = ExceptionCaster::castFrameStub($function, [], $function, true);
            $a[$prefix.'executing'] = $function[$prefix.'src'];
        }

        $a[Caster::PREFIX_VIRTUAL.'closed'] = false;

        return $a;
    }

    /**
     * @return array
     */
    public static function castClass(\ReflectionClass $c, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($n = \Reflection::getModifierNames($c->getModifiers())) {
            $a[$prefix.'modifiers'] = implode(' ', $n);
        }

        self::addMap($a, $c, [
            'extends' => 'getParentClass',
            'implements' => 'getInterfaceNames',
            'constants' => 'getReflectionConstants',
        ]);

        foreach ($c->getProperties() as $n) {
            $a[$prefix.'properties'][$n->name] = $n;
        }

        foreach ($c->getMethods() as $n) {
            $a[$prefix.'methods'][$n->name] = $n;
        }

        self::addAttributes($a, $c, $prefix);

        if (!($filter & Caster::EXCLUDE_VERBOSE) && !$isNested) {
            self::addExtra($a, $c);
        }

        return $a;
    }

    /**
     * @return array
     */
    public static function castFunctionAbstract(\ReflectionFunctionAbstract $c, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        self::addMap($a, $c, [
            'returnsReference' => 'returnsReference',
            'returnType' => 'getReturnType',
            'class' => \PHP_VERSION_ID >= 80111 ? 'getClosureCalledClass' : 'getClosureScopeClass',
            'this' => 'getClosureThis',
        ]);

        if (isset($a[$prefix.'returnType'])) {
            $v = $a[$prefix.'returnType'];
            $v = $v instanceof \ReflectionNamedType ? $v->getName() : (string) $v;
            $a[$prefix.'returnType'] = new ClassStub($a[$prefix.'returnType'] instanceof \ReflectionNamedType && $a[$prefix.'returnType']->allowsNull() && !\in_array($v, ['mixed', 'null'], true) ? '?'.$v : $v, [class_exists($v, false) || interface_exists($v, false) || trait_exists($v, false) ? $v : '', '']);
        }
        if (isset($a[$prefix.'class'])) {
            $a[$prefix.'class'] = new ClassStub($a[$prefix.'class']);
        }
        if (isset($a[$prefix.'this'])) {
            $a[$prefix.'this'] = new CutStub($a[$prefix.'this']);
        }

        foreach ($c->getParameters() as $v) {
            $k = '$'.$v->name;
            if ($v->isVariadic()) {
                $k = '...'.$k;
 