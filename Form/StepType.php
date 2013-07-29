<?php

namespace Flosy\Bundle\UseCaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scenario', 'entity', array(
                'class' => 'FlosyUseCaseBundle:Scenario',
                'query_builder' => function(EntityRepository $er) use ($options) {
                    $qb = $er->createQueryBuilder('s')
                               ->orderBy('s.name', 'ASC');
                    
                    if(isset($options['usecase'])){
                           $qb->where('s.useCase = :usecase')
                               ->setParameter('usecase', $options['usecase']);
                    }
                    return $qb;
                },
                'empty_value'   => 'Choose a step'
            ))
            ->add('description')
            ->add('position')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'usecase',
        ));
        
        $resolver->setDefaults(array(
            'data_class' => 'Flosy\Bundle\UseCaseBundle\Entity\Step',
            'usecase' => null,
        ));
    }

    public function getName()
    {
        return 'flosy_bundle_usecasebundle_steptype';
    }
}
