|string ...$addresses): static
    {
        return $this->addListAddressHeaderBody('To', $addresses);
    }

    /**
     * @return $this
     */
    public function to(Address|string ...$addresses): static
    {
        return $this->setListAddressHeaderBody('To', $addresses);
    }

    /**
     * @return Address[]
     */
    public function getTo(): array
    {
        return $this->getHeaders()->getHeaderBody('To') ?: [];
    }

    /**
     * @return $this
     */
    public function addCc(Address|string ...$addresses): static
    {
        return $this->addListAddressHeaderBody('Cc', $addresses);
    }

    /**
     * @return $this
     */
    public function cc(Address|string ...$addresses): static
    {
        return $this->setListAddressHeaderBody('Cc', $addresses);
    }

    /**
     * @return Address[]
     */
    public function getCc(): array
    {
        return $this->getHeaders()->getHeaderBody('Cc') ?: [];
    }

    /**
     * @return $this
     */
    public function addBcc(Address|string ...$addresses): static
    {
        return $this->addListAddressHeaderBody('Bcc', $addresses);
    }

    /**
     * @return $this
     */
    public function bcc(Address|string ...$addresses): static
    {
        return $this->setListAddressHeaderBody('Bcc', $addresses);
    }

    /**
     * @return Address[]
     */
    public function getBcc(): array
    {
        return $this->getHeaders()->getHeaderBody('Bcc') ?: [];
    }

    /**
     * Sets the priority of this message.
     *
     * The value is an integer where 1 is the highest priority and 5 is the lowest.
     *
     * @return $this
     */
    public function priority(int $priority): static
    {
        if ($priority > 5) {
            $priority = 5;
        } elseif ($priority < 1) {
            $priority = 1;
        }

        return $this->setHeaderBody('Text', 'X-Priority', \sprintf('%d (%s)', $priority, self::PRIORITY_MAP[$priority]));
    }

    /**
     * Get the priority of this message.
     *
     * The returned value is an integer where 1 is the highest priority and 5
     * is the lowest.
     */
    public function getPriority(): int
    {
        [$priority] = sscanf($this->getHeaders()->getHeaderBody('X-Priority') ?? '', '%[1-5]');

        return $priority ?? 3;
    }

    /**
     * @param resource|string|null $body
     *
     * @return $this
     */
    public function text($body, string $charset = 'utf-8'): static
    {
        if (null !== $body && !\is_string($body) && !\is_resource($body)) {
            throw new \TypeError(\sprintf('The body must be a string, a resource or null (got "%s").', get_debug_type($body)));
        }

        $this->cachedBody = null;
        $this->text = $body;
        $this->textCharset = $charset;

        return $this;
    }

    /**
     * @return resource|string|null
     */
    public function getTextBody()
    {
        return $this->text;
    }

    public function getTextCharset(): ?string
    {
        return $this->textCharset;
    }

    /**
     * @param resource|string|null $body
     *
     * @return $this
     */
    public function html($body, string $charset = 'utf-8'): static
    {
        if (null !== $body && !\is_string($body) && !\is_resource($body)) {
            throw new \TypeError(\sprintf('The body must be a string, a resource or null (got "%s").', get_debug_type($body)));
        }

        $this->cachedBody = null;
        $this->html = $body;
        $this->htmlCharset = $charset;

        return $this;
    }

    /**
     * @return resource|string|null
     */
    public function getHtmlBody()
    {
        return $this->html;
    }

    public function getHtmlCharset(): ?string
    {
        return $this->htmlCharset;
    }

    /**
     * @param resource|string $body
     *
     * @return $this
     */
    public function attach($body, ?string $name = null, ?string $contentType = null): static
    {
        return $this->addPart(new DataPart($body, $name, $contentType));
    }

    /**
     * @return $this
     */
    public function attachFromPath(string $path, ?string $name = null, ?string $contentType = null): static
    {
        return $this->addPart(new DataPart(new File($path), $name, $contentType));
    }

    /**
     * @param resource|string $body
     *
     * @return $this
     */
    public function embed($body, ?string $name = null, ?string $contentType = null): static
    {
        return $this->addPart((new DataPart($body, $name, $contentType))->asInline());
    }

    /**
     * @return $this
     */
    public function embedFromPath(string $path, ?string $name = null, ?string $contentType = null): static
    {
        return $this->addPart((new DataPart(new File($path), $name, $contentType))->asInline());
    }

    /**
     * @return $this
     *
     * @deprecated since Symfony 6.2, use addPart() instead
     */
    public function attachPart(DataPart $part): static
    {
        @trigger_deprecation('symfony/mime', '6.2', 'The "%s()" method is deprecated, use "addPart()" instead.', __METHOD__);

        return $this->addPart($part);
    }

    /**
     * @return $this
     */
    public function addPart(DataPart $part): static
    {
        $this->cachedBody = null;
        $this->attachments[] = $part;

        return $this;
    }

    /**
     * @return DataPart[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getBody(): AbstractPart
    {
        if (null !== $body = parent::getBody()) {
            return $body;
        }

        return $this->generateBody();
    }

    /**
     * @return void
     */
    public function ensureValidity()
    {
        $this->ensureBodyValid();

        if ('1' === $this->getHeaders()->getHeaderBody('X-Unsent')) {
            throw new LogicException('Cannot send messages marked as "draft".');
        }

        parent::ensureValidity();
    }

    private function ensureBodyValid(): void
    {
        if (null === $this->text && null === $this->html && !$this->attachments && null === parent::getBody()) {
            throw new LogicException('A message must have a text or an HTML part or attachments.');
        }
    }

    /**
     * Generates an AbstractPart based on the raw body of a message.
     *
     * The most "complex" 