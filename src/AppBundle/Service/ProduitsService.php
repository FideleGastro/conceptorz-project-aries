<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 23:47
 */

namespace AppBundle\Service;


use AppBundle\Entity\Produits;
use Doctrine\ORM\EntityManager;

class ProduitsService
{
    private $doctrne;
    private $produit;
    private $fournisseurs;

    use FournisseursProduitsTrait;

    /**
     * FournisseursService constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->setDoctrne($doctrine);
    }

    /**
     * Crée ou met à jour un produit
     * @param Produits $produit
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createOrUpdate(Produits $produit)
    {
        $date = new \DateTime();

        if (!is_null($produit->getId())) {
            $produit->setUpdatedAt($date);

        } else {

            $produit->setUpdatedAt($date);
            $produit->setCreatedAt($date);
        }

        $this->getDoctrne()->persist($produit);
        $this->getDoctrne()->flush();

        $this->setProduit($produit);

    }

    /**
     * Delete un produit
     *
     * @param Fournisseurs $fournisseur
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Produits $produits)
    {
        foreach ($produits->getProduitsFournisseurs() as $item) {
            $this->getDoctrne()->remove($item);
            $this->getDoctrne()->flush();
        }

        $this->getDoctrne()->remove($produits);
        $this->getDoctrne()->flush();
    }


    /**
     * @return mixed
     */
    public function getDoctrne()
    {
        return $this->doctrne;
    }

    /**
     * @param mixed $doctrne
     */
    public function setDoctrne($doctrne)
    {
        $this->doctrne = $doctrne;
    }

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
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

}