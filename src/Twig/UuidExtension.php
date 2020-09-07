<?php

namespace App\Twig;

use App\Doctrine\UuidEncoder;
use Ramsey\Uuid\UuidInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UuidExtension extends AbstractExtension
{
    private $encoder;

    public function __construct(UuidEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'uuid_encode',
                [$this, 'encodeUuid'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function encodeUuid(UuidInterface $uuid): string
    {
        return $this->encoder->encode($uuid);
    }
}