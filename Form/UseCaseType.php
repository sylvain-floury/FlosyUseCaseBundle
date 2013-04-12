<?php

namespace Flosy\Bundle\UseCaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UseCaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'entity', array(
                'class' => 'FlosyUseCaseBundle:Project'
            ))
            ->add('title')
            ->add('aim', 'textarea', array(
                'max_length' => 500 
            ))
            ->add('precondition', 'textarea', array(
                'max_length' => 500 
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flosy\Bundle\UseCaseBundle\Entity\UseCase',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'flosy_bundle_usecasebundle_usecasetype';
    }
}
