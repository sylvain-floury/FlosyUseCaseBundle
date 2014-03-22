<?php

namespace Flosy\Bundle\UseCaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UseCaseType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('project')
            ->add('actors', 'entity', array(
                'class'    => 'FlosyUseCaseBundle:Actor',
                'expanded' => TRUE,
                'multiple' => TRUE,
            ))
            ->add('precondition', 'textarea', array('attr' => array(
                'rows' => 5,
            )))
            ->add('aim', 'textarea', array('attr' => array(
                'rows' => 5
            )))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flosy\Bundle\UseCaseBundle\Entity\UseCase'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'flosy_bundle_usecasebundle_usecase';
    }
}
