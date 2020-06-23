<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCmd;

    /**
     * @ORM\Column(type="integer")
     */
    private $livree;



    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="commande")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->dateCmd;
    }

    public function setDateCmd(\DateTimeInterface $dateCmd): self
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function getLivree(): ?int
    {
        return $this->livree;
    }

    public function setLivree(int $livree): self
    {
        $this->livree = $livree;

        return $this;
    }


    /**
     * Get the value of facture
     */ 
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set the value of facture
     *
     * @return  self
     */ 
    public function setFacture($facture)
    {
        $this->facture = $facture;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addCommande($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            $article->removeCommande($this);
        }

        return $this;
    }


}
