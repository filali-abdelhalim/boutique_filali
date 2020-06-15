<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $Apayer;

    /**
     * @ORM\Column(type="float")
     */
    private $payee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApayer(): ?float
    {
        return $this->Apayer;
    }

    public function setApayer(float $Apayer): self
    {
        $this->Apayer = $Apayer;

        return $this;
    }

    public function getPayee(): ?float
    {
        return $this->payee;
    }

    public function setPayee(float $payee): self
    {
        $this->payee = $payee;

        return $this;
    }
}
