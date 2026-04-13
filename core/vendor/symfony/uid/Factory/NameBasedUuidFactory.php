= $f['file'];
                $ellipsis = new LinkStub($srcKey, 0);
                $srcAttr = 'collapse='.(int) $ellipsis->inVendor;
                $ellipsisTail = $ellipsis->attr['ellipsis-tail'] ?? 0;
                $ellipsis = $ellipsis->attr['ellipsis'] ?? 0;

                if (is_file($f['file']) && 0 <= self::$srcContext) {
                    if (!empty($f['class']) && (is_subclass_of($f['class'], 'Twig\Template') || is_subclass_of($f['class'], 'Twig_Template')) && method_exists($f['class'], 'getDebugInfo')) {
                        $template = null;
                        if (isset($f['object'])) {
                            $template = $f['object'];
                        } elseif ((new \ReflectionClass($f['class']))->isInstantiable()) {
                            $template = unserialize(\sprintf('O:%d:"%s":0:{}', \strlen($f['class']), $f['class']));
                        }
                        if (null !== $template) {
                            $ellipsis = 0;
                