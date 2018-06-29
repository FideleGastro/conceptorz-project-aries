<?php

namespace AppBundle\Form;

use AppBundle\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
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
                'choice_attr' => function($produit) use ($options){
                    $attr = array();
                    if(!empty($options['data']))
                    {
                        foreach ($options['data']->getFournisseursProduits() as $item){
                            if($produit->getId() == $item->getProduits()->getId()){
                                $attr['checked'] = 'checked';
                            }
                        }
                    }

                    return $attr;
                })
            )
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Fournisseurs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_fournisseurs';
    }


}
