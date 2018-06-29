<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Fournisseurs;
use AppBundle\Entity\Produits;
use AppBundle\Service\FournisseursProduitsTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class produitsAdmin extends AbstractAdmin
{
    use FournisseursProduitsTrait;
    protected $produit;

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produits
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsDate = array();
        $fournisseurs = array();
        if(is_null($formMapper->getAdmin()->getSubject()->getId())){
            $optionsDate = array('data' => new \DateTime());
        }
        //var_dump($formMapper->getAdmin()->getSubject());
        foreach($formMapper->getAdmin()->getSubject()->getProduitsFournisseurs() as $item){
            //dump($item->getFournisseurs());
            $fournisseurs[$item->getFournisseurs()->getId()] = $item->getFournisseurs();
        }
        $formMapper
            ->add('nom')
        ->add('is_active')
        ->add('prix_achat')
        ->add('prix_vente')
        ->add('fournisseur', EntityType::class, array(
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,
                'class' => Fournisseurs::class,
                'choice_attr' => function($fournisseur) use ($fournisseurs){
                    $attr = array();
                    if(array_key_exists($fournisseur->getId(), $fournisseurs) !== false){
                              $attr['checked'] = 'checked';
                    }
                    return $attr;
                })
        )
        ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_label' => '...',
            'download_uri' => true,
            'image_uri' => true,
            'imagine_pattern' => 'my_thumb',
        ])
        ->add('created_at')
        ->add('updated_at');
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
            ->add('updated_at');
    }

    public function postUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $this->setDoctrne($container->get('doctrine')->getManager());
        $dataForm = $this->getForm()->get('fournisseur')->getData();
        $temp = array();

        foreach ($dataForm as $item) {
            $temp[] = $item->getId();
        }
        //dump($temp);
        $this->setProduit($object);
        $this->relationsProduitsManager($temp);
       // die();

    }
}