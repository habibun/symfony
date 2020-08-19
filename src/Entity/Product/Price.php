<?php

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Price
{

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $amount;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $currency;

    public function __construct(float $amount, string $currency)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Given amount ' . $amount . ' must be bigger then 0!');
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function __toString(): string
    {
        return $this->currency . ' ' . $this->amount;
    }

    public function equals(Price $price): bool
    {
        return ((string)$this) === ((string)$price);
    }
}