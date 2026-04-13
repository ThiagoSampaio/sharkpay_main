ster::EXCLUDE_VERBOSE) && $trace) {
            if (isset($a[Caster::PREFIX_PROTECTED.'file'], $a[Caster::PREFIX_PROTECTED.'line'])) {
                self::traceUnshift($trace, $xClass, $a[Caster::PREFIX_PROTECTED.'file'], $a[Caster::PREFIX_PROTECTED.'line']);
            }
            $a[Caster::PREFIX_VIRTUAL.'trace'] = new TraceStub($trace, self::$traceArgs);
        }
        if (empty($a[$xPrefix.'previous'])) {
            unset($a[$xPrefix.'previous']);
        }
        unset($a[$xPrefix.'string'], $a[Caster::PREFIX_DYNAMIC.'xdebug_message']);

        if (isset($a[Caster::PREFIX_PROTECTED.'message']) && str_contains($a[Caster::PREFIX_PROTECTED.'message'], "@anonymous\0")) {
            $a[Caster::PREFIX_PROTECTED.'message'] = preg_replace_callback('/[a-zA-Z_\x7f-\xff][\\\\a-zA-Z0-9_\x7f-\xff]*+@anonymous\x00.*?\.php(?:0x?|:[0-9]++\$)?[0-9a-fA-F]++/', fn ($m) =