<?php

namespace Wabbox\LettreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('objet',   'text')
        ->add('message', 'textarea')
            //->add('personne',  new PersonneType())
        ->add('personne', 'entity', array(
            'class' => 'WabboxLettreBundle:Personne',
            'expanded' => true,
            'multiple' => false,
            'property' => 'nom',
            'query_builder' => function(EntityRepository $er) {
                return $er -> createQueryBuilder('a') 
                           -> leftJoin('a.user', 'u') 
                           -> addSelect('u')          
                           -> Where('a.expediteur = :expediteur')
                           -> setParameter('expediteur', false)
                           -> orderBy('a.nom', 'ASC');
            },
            ));
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wabbox\LettreBundle\Entity\Contenu'
            ));
    }

    public function getName()
    {
        return 'wabbox_lettrebundle_contenutype';
    }
}
