<?php
/**
 * Created by PhpStorm.
 * User: Gaap_
 * Date: 17/06/2018
 * Time: 23:47
 */

namespace AppBundle\Service;


use AppBundle\Entity\Fournisseurs;
use AppBundle\Entity\FournisseursProduits;
use AppBundle\Entity\Produits;
use Doctrine\ORM\EntityManager;

class FournisseursService
{
    private $doctrne;
    private $fournisseur;

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
     * Crée ou met à jour un fournisseur
     * @param Fournisseurs $fournisseur
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createOrUpdate(Fournisseurs $fournisseur)
    {
        $date = new \DateTime();

        if (!is_null($fournisseur->getId())) {
            $fournisseur->setUpdatedAt($date);
        } else {

            $fournisseur->setUpdatedAt($date);
            $fournisseur->setCreatedAt($date);
        }

        $this->getDoctrne()->persist($fournisseur);
        $this->getDoctrne()->flush();

        $this->setFournisseur($fournisseur);
    }

//    /**
//     * Rajoute les nouvelle relation
//     *
//     * @param array $produits
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function relationsManager(array $produits = array())
//    {
//        foreach ($relationProduitAjout = $this->nettoyageRelations($produits) as $item) {
//            if ($produit = $this->getDoctrne()->getRepository(Produits::class)->findOneById($item)) {
//
//                $date = new \DateTime();
//                $relationFournisseurProduit = new FournisseursProduits();
//                $relationFournisseurProduit->setProduits($produit);
//                $relationFournisseurProduit->setFournisseurs($this->getFournisseur());
//                $relationFournisseurProduit->setUpdatedAt($date);
//                $relationFournisseurProduit->setCreatedAt($date);
//
//                $this->getDoctrne()->persist($relationFournisseurProduit);
//                $this->getDoctrne()->flush();
//            }
//        }
//    }
//
//    /**
//     * Supprime les relations inexistantes et met la date d'update à jour pour celle conservée
//     *
//     * @param array $produits
//     * @return array
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    private function nettoyageRelations(array $produits = array())
//    {
//        var_dump($produits);
//        /** @var FournisseursProduits $item */
//        foreach ($this->getFournisseur()->getFournisseursProduits() as $item) {
//            $key = array_search($item->getProduits()->getId(), $produits);
//            if ($key === false) {
//                $this->getDoctrne()->remove($item);
//                $this->getDoctrne()->flush();
//            } else {
//                unset($produits[$key]);
//                $item->setUpdatedAt(new \DateTime());
//                $this->getDoctrne()->persist($item);
//                $this->getDoctrne()->flush();
//            }
//        }
//
//        return $produits;
//    }

    /**
     * Delete un fournisseur
     *
     * @param Fournisseurs $fournisseur
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Fournisseurs $fournisseur)
    {
        foreach ($fournisseur->getFournisseursProduits() as $item) {
            $this->getDoctrne()->remove($item);
            $this->getDoctrne()->flush();
        }

        $this->getDoctrne()->remove($fournisseur);
        $this->getDoctrne()->flush();
    }

    /**
     * @return EntityManager
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
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param mixed $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }


}