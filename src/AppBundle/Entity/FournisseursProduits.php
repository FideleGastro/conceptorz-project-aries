<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 23:09
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Produits_Fournisseurs
 *
 * @ORM\Table(name="fournisseurs_produits", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FournisseursProduitsRepository")
 */
class FournisseursProduits
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fournisseurs", inversedBy="fournisseurs_produits")
     */
    private $fournisseurs;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produits", inversedBy="produits_fournisseurs")
     */
    private $produits;

    /**
     * @ORM\Column("created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @ORM\Column("updated_at", type="datetime", nullable=false)
     */
    private $updated_at;

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
    public function getFournisseurs()
    {
        return $this->fournisseurs;
    }

    /**
     * @param mixed $fournisseurs
     */
    public function setFournisseurs($fournisseurs)
    {
        $this->fournisseurs = $fournisseurs;
    }

    /**
     * @return mixed
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * @param mixed $produits
     */
    public function setProduits($produits)
    {
        $this->produits = $produits;
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


}