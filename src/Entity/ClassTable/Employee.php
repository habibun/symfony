<?php

namespace App\Entity\ClassTable;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="employee_joined", indexes={@ORM\Index(name="type_idx", columns={"type"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"Acc"="Accountant","Dev"="Developer","Mar"="Marketer"})
 */
abstract class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=100)
     */
    private $level;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $level
     * @return $this
     */
    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }
}
