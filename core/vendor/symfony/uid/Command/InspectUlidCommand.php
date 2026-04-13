) {
            foreach ($v as $k => &$v) {
                if (\is_object($v)) {
                    $a[$prefix.'use']['$'.$k] = new CutStub($v);
                } else {
                    $a[$prefix.'use']['$'.$k] = &$v;
                }
            }
            unset($v);
            $a[$prefix.'use'] = new EnumStub($a[$prefix.'use']);
        }

        if (!($filter & Caster::EXCLUDE_VERBOSE) && !$isNested) {
            self::addExtra($a, $c);
        }

        return $a;
    }

    /**
     * @return array
     */
    public static function castClassConstant(\ReflectionClassConstant $c, array $a, Stub $stub, bool $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));
        $a[Caster::PREFIX_VIRTUAL.'value'] = $c->getValue();

        self::addAttributes($a, $c);

        return $a;
    }

    /**
     * @return array
     */
    public static function castMethod(\ReflectionMethod $c, array $a, Stub $stub, bool $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'modifiers'] = implode(' ', \Reflection::getModifierNames($c->getModifiers()));

        return $a;
    }

    /**
     * @return array
     */
    public static function castParameter(\ReflectionParameter $c, array $a, Stub $stub, bool $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        self::addMap($a, $c, [
            'position' => 'getPosition',
            'isVariadic' => 'isVariadic',
            'byReference' => 'isPassedByReference',
            'allowsNull' => 'allowsNull',
        ]);

        self::addAttributes($a, $c, $prefix);

        if ($v = $c->getType()) {
            $a[$prefix.'typeHint'] = $v instanceof \ReflectionNamedType ? $v->getName() : (string) $v;
        }

        if (isset($a[$prefix.'typeHint'])) {
            $v = $a[$prefix.'typeHint'];
            $a[$prefix.'typeHint'] = new ClassStub($v, [class_exists($v, false) || interface_exists($v, false) || trait_exists($v, false) ? $v : '', '']);
        } else {
            unset($a[$prefix.'allowsNull']);
        }

        if ($c->isOptional()) {
            try {
                $a[$prefix.'default'] = $v = $c->getDefaultValue();
                if ($c->isDefaultValueConstan