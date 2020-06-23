<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 */
class Marque
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle_marque;

       
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="marque",orphanRemoval=true)
     */
    private $articles;
  

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }
   
    public function getLibelleMarque(): ?string
    {
        return $this->libelle_marque;
    }

    public function setLibelleMarque(string $libelle_marque): self
    {
        $this->libelle_marque = $libelle_marque;

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
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->libelle_marque;
        // to show the id of the Category in the select
        // return $this->id;
    }



    /**
     * Get the value of articles
     */ 
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set the value of articles
     *
     * @return  self
     */ 
    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }
}
