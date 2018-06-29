<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 23:08
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fournisseurs
 *
 * @ORM\Table(name="fournisseurs", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FournisseursRepository")
 */
class Fournisseurs
{
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
     * @ORM\Column("adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @ORM\Column("siret", type="string", length=16, nullable=false)
     */
    private $siret;

    /**
     * @ORM\Column("active", type="boolean", nullable=false)
     */
    private $is_active;

    /**
     * @ORM\Column("created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @ORM\Column("updated_at", type="datetime", nullable=false)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FournisseursProduits", mappedBy="fournisseurs")
     */
    private $fournisseurs_produits;

    public function __toString()
    {
        return $this->nom;
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
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param mixed $siret
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
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
    public function getFournisseursProduits()
    {
        return $this->fournisseurs_produits;
    }

    /**
     * @param mixed $fournisseurs_produits
     */
    public function setFournisseursProduits($fournisseurs_produits)
    {
        $this->fournisseurs_produits = $fournisseurs_produits;
    }



}