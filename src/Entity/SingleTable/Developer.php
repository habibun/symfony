<?php

namespace App\Entity\SingleTable;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Developer extends Employee
{
    /**
     * @var string
     *
     * @ORM\Column(name="calibre", type="string", length=100)
     */
    private $calibre;

    /**
     * @param string $calibre
     * @return $this
     */
    public function setCalibre(string $calibre): self
    {
        $this->calibre = $calibre;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalibre(): string
    {
        return $this->calibre;
    }
}