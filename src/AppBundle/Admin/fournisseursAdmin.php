<?php
/**
 * Created by PhpStorm.
 * User: Aries
 * Date: 26/06/2018
 * Time: 16:34
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Fournisseurs;
use AppBundle\Entity\Produits;
use AppBundle\Service\FournisseursProduitsTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class fournisseursAdmin extends AbstractAdmin
{
    use FournisseursProduitsTrait;
    protected $fournisseur;

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

    protected function configureFormFields(FormMapper $formMapper)
    {

        $Produits = array();
        foreach($formMapper->getAdmin()->getSubject()->getFournisseursProduits() as $item){
            //dump($item->getFournisseurs());
            $Produits[$item->getProduits()->getId()] = $item->getProduits();
        }

        $formMapper
            ->add('id')
            ->add('nom')
            ->add('adresse')
            ->add('siret')
            ->add('is_active')
            ->add('created_at')
            ->add('updated_at')
            ->add('produit', EntityType::class, array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'mapped' => false,
                    'class' => Produits::class,
                    'choice_attr' => function($produit) use ($Produits){
                        $attr = array();
                        if(array_key_exists($produit->getId(), $Produits) !== false){
                            $attr['checked'] = 'checked';
                        }
                        return $attr;
                    })
            );
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nom');
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('nom')
            ->add('is_active')
            ->add('created_at')
            ->add('updated_at')
            ->add('siret')
            ;
    }

    public function postUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $this->setDoctrne($container->get('doctrine')->getManager());
        $dataForm = $this->getForm()->get('produit')->getData();
        $temp = array();
        foreach ($dataForm as $item) {
            $temp[] = $item->getId();
        }
        //dump($temp);
        $this->setFournisseur($object);
        $this->relationsManager($temp);
        // die();

    }
}