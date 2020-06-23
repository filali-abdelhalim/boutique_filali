<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="articles", fileNameProperty="imageName")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;


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
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande", inversedBy="articles")
     */
    private $commande;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
    }

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

    /**
     * Get nOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @return  File|null
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set nOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @param  File|null  $imageFile  NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @return  self
     */ 
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updateAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get the value of imageName
     *
     * @return  string|null
     */ 
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     *
     * @param  string|null  $imageName
     *
     * @return  self
     */ 
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->contains($commande)) {
            $this->commande->removeElement($commande);
        }

        return $this;
    }

}
