<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Titre de l\'article:'
            ))
            ->add('contenu', TextareaType::class, array(
                'label' => 'Contenu :'
            ))
            ->add('dateParution', DateType::class, array(
                'label' => 'Date de parution de l\'article :',
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy',
                'attr'     => array(
                    'class'       => 'js-datepicker',
                    'placeholder' => 'jj/mm/aaaa'
                )
            ))
            ->add('categorie', EntityType::class, array(
                'label' => 'Catégorie :',
                'class' => 'AppBundle:Categorie',
                'choice_label' => 'nom',
                //'expanded' => true
            ))
            ->add('tags', EntityType::class, array(
                'label' => 'Tags :',
                'class' => 'AppBundle:Tag',
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
