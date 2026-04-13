<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime;

use Symfony\Component\Mime\Exception\LogicException;
use Symfony\Component\Mime\Part\AbstractPart;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Mime\Part\Multipart\AlternativePart;
use Symfony\Component\Mime\Part\Multipart\MixedPart;
use Symfony\Component\Mime\Part\Multipart\RelatedPart;
use Symfony\Component\Mime\Part\TextPart;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Email extends Message
{
    public const PRIORITY_HIGHEST = 1;
    public const PRIORITY_HIGH = 2;
    public const PRIORITY_NORMAL = 3;
    public const PRIORITY_LOW = 4;
    public const PRIORITY_LOWEST = 5;

    private const PRIORITY_MAP = [
        self::PRIORITY_HIGHEST => 'Highest',
        self::PRIORITY_HIGH => 'High',
        self::PRIORITY_NORMAL => 'Normal',
        self::PRIORITY_LOW => 'Low',
        self::PRIORITY_LOWEST => 'Lowest',
    ];

    /**
     * @var resource|string|null
     */
    private $text;

    private ?string $textCharset = null;

    /**
     * @var resource|string|null
     */
    private $html;

    private ?string $htmlCharset = null;
    private array $attachments = [];
    private ?AbstractPart $cachedBody = null; // Used to avoid wrong body hash in DKIM signatures with multiple parts (e.g. HTML + TEXT) due to multiple boundaries.

    /**
     * @return $this
     */
    public function subject(string $subject): static
    {
        return $this->setHeaderBody('Text', 'Subject', $subject);
    }

    public function getSubject(): ?string
    {
        return $this->getHeaders()->getHeaderBody('Subject');
    }

    /**
     * @return $this
     */
    public function date(\DateTimeInterface $dateTime): static
    {
        return $this->setHeaderBody('Date', 'Date', $dateTime);
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->getHeaders()->getHeaderBody('Date');
    }

    /**
     * @return $this
     */
    public function returnPath(Address|string $address): static
    {
        return $this->setHeaderBody('Path', 'Return-Path', Address::create($address));
    }

    public function getReturnPath(): ?Address
    {
        return $this->getHeaders()->getHeaderBody('Return-Path');
    }

    /**
     * @return $this
     */
    public function sender(Address|string $address): static
    {
        return $this->setHeaderBody('Mailbox', 'Sender', Address::create($address));
    }

    public function getSender(): ?Address
    {
        return $this->getHeaders()->getHeaderBody('Sender');
    }

    /**
     * @return $this
     */
    public function addFrom(Address|string ...$addresses): static
    {
        return $this->addListAddressHeaderBody('From', $addresses);
    }

    /**
     * @return $this
     */
    public function from(Address|string ...$addresses): static
    {
        if (!$addre