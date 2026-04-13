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

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\ErrorHandler\Exception\SilencedErrorContext;
use Symfony\Component\VarDumper\Cloner\Stub;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

/**
 * Casts common Exception classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
 */
class ExceptionCaster
{
    public static int $srcContext = 1;
    public static bool $traceArgs = true;
    public static array $errorTypes = [
        \E_DEPRECATED => 'E_DEPRECATED',
        \E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        \E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        \E_ERROR => 'E_ERROR',
        \E_WARNING => 'E_WARNING',
        \E_PARSE => 'E_PARSE',
        \E_NOTICE => 'E_NOTICE',
        \E_CORE_ERROR => 'E_CORE_ERROR',
        \E_CORE_WARNING => 'E_CORE_WARNING',
        \E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        \E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        \E_USER_ERROR => 'E_USER_ERROR',
        \E_USER_WARNING => 'E_USER_WARNING',
        \E_USER_NOTICE => 'E_USER_NOTICE',
        2048 => 'E_STRICT',
    ];

    private static array $framesCache = [];

    /**
     * @return array
     */
    public static function castError(\Error $e, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        return self::filterExceptionArray($stub->class, $a, "\0Error\0", $filter);
    }

    /**
     * @return array
     */
    public static function castException(\Exception $e, array $a, Stub $stub, bool $isNested, int $filter = 0)
    {
        return self::filterExceptionArray($stub->class, $a, "\0Exception\0", $filter);
    }

    /**
     * @return array
     */
    public static function castErrorException(\ErrorException $e, array $a, Stub $stub, bool $isNested)
    {
        if (isset($a[$s = Caster::PREFIX_PROTECTED.'severity'], self::$errorTypes[$a[$s]])) {
            $a[$s] = new ConstStub(self::$errorTypes[$a[$s]], $a[$s]);
        }

        return $a;
    }

    /**
     * @return array
     */
    public static function castThrowingCasterException(ThrowingCasterException $e, array $a, Stub $stub, bool $isNested)
    {
        $trace = Caster::PREFIX_VIRTUAL.'trace';
        $prefix = Caster::PREFIX_PROTECTED;
        $xPrefix = "\0Exception\0";

        if (isset($a[$xPrefix.'previous'], $a[$trace]) && $a[$xPrefix.'previous'] instanceof \Exception) {
            $b = (array) $a[$xPrefix.'previous'];
            $class = get_debug_type($a[$xPrefix.'previous']);
            self::traceUnshift($b[$xPrefix.'trace'], $class, $b[$prefix.'file'], $b[$prefix.'line']);
            $a[$trace] = new TraceStub($b[$xPrefix.'trace'], false, 0, -\count($a[$trace]->value));
        }

        unset($a[$xPrefix.'previous'], $a[$prefix.'code'], $a[$prefix.'file'], $a[$prefix.'line']);

        return $a;
    }

    /**
     * @return array
     */
    public static function castSilencedErrorContext(SilencedErrorContext $e, array $a, Stub $stub, bool $isNested)
    {
        $sPrefix = "\0".SilencedErrorContext::class."\0";

        if (!isset($a[$s = $sPrefix.'severity'])) {
            return $a;
        }

        if (isset(self::$errorTypes[$a[$s]])) {
            $a[$s] = new ConstStub(self::$errorTypes[$a[$s]], $a[$s]);
        }

        $trace = [[
            'file' => $a[$sPrefix.'file'],
            'line' => $a[$sPrefix.'line'],
        ]];

        if (isset($a[$sPrefix.'trace'])) {
            $trace = array_merge($trace, $a[$sPrefix.'trace']);
        }

        unset($a[$sPrefix.'file'], $a[$sPrefix.'line'], $a[$sPrefix.'trace']);
        $a[Caster::PREFIX_VIRTUAL.'trace'] = new TraceStub($trace, self::$traceArgs);

        return $a;
    }

    /**
     * @return array
     */
    public static function castTraceStub(TraceStub $trace, array $a, Stub $stub, bool $isNested)
    {
        if (!$isNested) {
            return $a;
        }
        $stub->class = '';
        $stub->handle = 0;
        $frames = $trace->value;
        $prefix = Caster::PREFIX_VIRTUAL;

        $a = [];
        $j = \count($frames);
        if (0 > $i = $trace->sliceOffset) {
            $i = max(0, $j + $i);
        }
        if (!isset($trace->value[$i])) {
            return [];
        }
        $lastCall = isset($frames[$i]['function']) ? (isset($frames[$i]['class']) ? $frames[0]['class'].$frames[$i]['type'] : '').$frames[$i]['function'].'()' : '';
        $frames[] = ['function' => ''];
        $collapse = false;

        for ($j += $trace->numberingOffset - $i++; isset($frames[$i]); ++$i, --$j) {
            $f = $frames[$i];
            $call = isset($f['function']) ? (isset($f['class']) ? $f['class'].$f['type'] : '').$f['function'] : '???';

            $frame = new FrameStub(
                [
                    'object' => $f['object'] ?? null,
                    'class' => $f['class'] ?? null,
                    'type' => $f['type'] ?? null,
                    'function' => $f['function'] ?? null,
                ] + $frames[$i - 1],
                fa