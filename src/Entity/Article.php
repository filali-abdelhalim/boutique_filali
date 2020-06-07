<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     */

    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="Marque")
     */
    private $marque;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomArt;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_initial;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promo;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_final;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="articles")
     */
    private $commande;

    
    public function getNomArt()
    {
        return $this->nomArt;
    }

    /**
     * Set the value of nomArt
     *
     * @return  self
     */ 
    public function setNomArt($nomArt)
    {
        $this->nomArt = $nomArt;

        return $this;
    }
      

    public function getPrixInitial(): ?float
    {
        return $this->prix_initial;
    }

    public function setPrixInitial(float $prix_initial): self
    {
        $this->prix_initial = $prix_initial;

        return $this;
    }

  
    public function getPrixFinal(): ?float
    {
        return $this->prix_final;
    }

    public function setPrixFinal(float $prix_final): self
    {
        $this->prix_final = $prix_final;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

   
    /**
     * Get the value of categorie
     */ 
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set the value of categorie
     *
     * @return  self
     */ 
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get the value of marque
     */ 
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set the value of marque
     *
     * @return  self
     */ 
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of promo
     */ 
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set the value of promo
     *
     * @return  self
     */ 
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

}
