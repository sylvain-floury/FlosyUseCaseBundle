<?php

namespace Flosy\Bundle\UseCaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ScenarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('useCase', 'entity', array(
                'class' => 'FlosyUseCaseBundle:UseCase',
                'query_builder' => function(EntityRepository $er) use ($options) {
                    $qb = $er->createQueryBuilder('uc')
                               ->orderBy('uc.title', 'ASC');
                    
                    if(isset($options['project'])){
                           $qb->where('uc.project = :project')
                               ->setParameter('project', $options['project']);
                    }
                    return $qb;
                },
                'empty_value'   => 'Choose a scenario'
            ))
            ->add('name')
            ->add('type', 'choice', array(
                'choices'   => array(
                    'main' => 'Main',
                    'secondary' => 'Secondary'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'project',
        ));
        
        $resolver->setDefaults(array(
            'data_class' => 'Flosy\Bundle\UseCaseBundle\Entity\Scenario',
            'project' => null,
        ));
    }

    public function getName()
    {
        return 'flosy_bundle_usecasebundle_scenariotype';
    }
}
