{
                            continue 2;
                        }
                        if (!preg_match('//u', $v)) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_STRING;
                            $stub->class = Stub::STRING_BINARY;
                            if (0 <= $maxString && 0 < $cut = \strlen($v) - $maxString) {
                                $stub->cut = $cut;
                                $stub->value = substr($v, 0, -$cut);
                            } else {
                                $stub->value = $v;
                            }
                        } elseif (0 <= $maxString && isset($v[1 + ($maxString >> 2)]) && 0 < $cut = mb_strlen($v, 'UTF-8') - $maxString) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_STRING;
                            $stub->class = Stub::STRING_UTF8;
                            $stub->cut = $cut;
                            $stub->value = mb_substr($v, 0, $maxString, 'UTF-8');
                        } else {
                            continue 2;
                        }
                        $a = null;
                        break;

                    case \is_array($v):
                        if (!$v) {
                            continue 2;
                        }
                        $stub = $arrayStub;

                        $stub->class = array_is_list($v) ? Stub::ARRAY_INDEXED : Stub::ARRAY_ASSOC;
                        $a = $v;
                        break;

                    case \is_object($v):
                        if (empty($objRefs[$h = spl_object_id($v)])) {
                            $stub = new Stub();
                            $stub->type = Stub::TYPE_OBJECT;
                            $stub->class = $v::class;
                            $stub->value = $v;
                            $stub->handle = $h;
                            $a = $this->castObject($stub, 0 < $i);
                            if ($v !== $stub->value) {
                                if (Stub::TYPE_OBJECT !== $stub->type || null === $stub->value) {
                                    break;
                                }
                                $stub->handle = $h = spl_object_id($stub->value);
                            }
                            $stub->value = null;
            