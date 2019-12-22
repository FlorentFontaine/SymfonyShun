<?php

namespace Flo\PortfolioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AdvertType extends AbstractType{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder
        ->add('title',     TextType::class)
        ->add('author',    TextType::class)
        ->add('path',      TextType::class)
        ->add('content',   TextareaType::class)
        ->add('published', CheckboxType::class, array('required' => false))
        ->add('image',     ImageType::class)
        ->add('categories', EntityType::class, array(
            'class'        => 'FloPortfolioBundle:Category',
            'choice_label' => 'name',
            'multiple'     => true,
            ))        
        ->add('save',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flo\PortfolioBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'flo_portfoliobundle_advert';
    }
}
