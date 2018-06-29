<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 23:47
 */

namespace AppBundle\Service;


use AppBundle\Entity\Fournisseurs;
use AppBundle\Entity\Produits;
use AppBundle\Entity\FournisseursProduits;

trait FournisseursProduitsTrait
{

    /**
     * Rajoute les nouvelle relation
     *
     * @param array $produits
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function relationsManager(array $produits = array())
    {
        foreach ($relationProduitAjout = $this->nettoyageRelations($produits) as $item) {
            if ($produit = $this->getDoctrne()->getRepository(Produits::class)->findOneById($item)) {

                $date = new \DateTime();
                $relationFournisseurProduit = new FournisseursProduits();
                $relationFournisseurProduit->setProduits($produit);
                $relationFournisseurProduit->setFournisseurs($this->getFournisseur());
                $relationFournisseurProduit->setUpdatedAt($date);
                $relationFournisseurProduit->setCreatedAt($date);

                $this->getDoctrne()->persist($relationFournisseurProduit);
                $this->getDoctrne()->flush();
            }
        }
    }

    /**
     * Supprime les relations inexistantes et met la date d'update à jour pour celle conservée
     *
     * @param array $produits
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function nettoyageRelations(array $produits = array())
    {
        /** @var FournisseursProduits $item */
        foreach ( ($this->getFournisseur()->getFournisseursProduits()) ? : array() as $item) {
            $key = array_search($item->getProduits()->getId(), $produits);
            if ($key === false) {
                $this->getDoctrne()->remove($item);
                $this->getDoctrne()->flush();
            } else {
                unset($produits[$key]);
                $item->setUpdatedAt(new \DateTime());
                $this->getDoctrne()->persist($item);
                $this->getDoctrne()->flush();
            }
        }
        return $produits;
    }

    /**
     * Rajoute les nouvelle relation
     *
     * @param array $produits
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function relationsProduitsManager(array $fournisseurs = array())
    {
        foreach ($relationFournisseurAjout = $this->nettoyageProduitsRelations($fournisseurs) as $item) {
            if ($fournisseurs = $this->getDoctrne()->getRepository(Fournisseurs::class)->findOneById($item)) {

                $date = new \DateTime();
                $relationProduitFournisseur = new FournisseursProduits();
                $relationProduitFournisseur->setProduits($this->getProduit());
                $relationProduitFournisseur->setFournisseurs($fournisseurs);
                $relationProduitFournisseur->setUpdatedAt($date);
                $relationProduitFournisseur->setCreatedAt($date);

                $this->getDoctrne()->persist($relationProduitFournisseur);
                $this->getDoctrne()->flush();
            }
        }
    }

    /**
     * Supprime les relations inexistantes et met la date d'update à jour pour celle conservée
     *
     * @param array $produits
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function nettoyageProduitsRelations(array $fournisseurs = array())
    {
        /** @var FournisseursProduits $item */
        foreach ( ($this->getProduit()->getProduitsFournisseurs()) ? : array() as $item) {
            $key = array_search($item->getFournisseurs()->getId(), $fournisseurs);
            if ($key === false) {
                $this->getDoctrne()->remove($item);
                $this->getDoctrne()->flush();
            } else {
                unset($fournisseurs[$key]);
                $item->setUpdatedAt(new \DateTime());
                $this->getDoctrne()->persist($item);
                $this->getDoctrne()->flush();
            }
        }

        return $fournisseurs;
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



}