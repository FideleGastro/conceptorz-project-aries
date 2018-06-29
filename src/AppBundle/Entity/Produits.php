<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 23:09
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Produits
 *
 * @ORM\Table(name="produits", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitsRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Produits
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column("nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @ORM\Column("active", type="boolean", nullable=false)
     */
    private $is_active;

    /**
     * @ORM\Column("prix_achat", type="float", nullable=false)
     */
    private $prix_achat;

    /**
     * @ORM\Column("prix_vente", type="float", nullable=false)
     */
    private $prix_vente;

    /**
     * @ORM\Column("created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @ORM\Column("updated_at", type="datetime", nullable=false)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FournisseursProduits", mappedBy="produits")
     */
    private $produits_fournisseurs;

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nom ? : '';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function getPrixAchat()
    {
        return $this->prix_achat;
    }

    /**
     * @param mixed $prix_achat
     */
    public function setPrixAchat($prix_achat)
    {
        $this->prix_achat = $prix_achat;
    }

    /**
     * @return mixed
     */
    public function getPrixVente()
    {
        return $this->prix_vente;
    }

    /**
     * @param mixed $prix_vente
     */
    public function setPrixVente($prix_vente)
    {
        $this->prix_vente = $prix_vente;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getProduitsFournisseurs()
    {
        return $this->produits_fournisseurs;
    }

    /**
     * @param mixed $produits_fournisseurs
     */
    public function setProduitsFournisseurs($produits_fournisseurs)
    {
        $this->produits_fournisseurs = $produits_fournisseurs;
    }



}