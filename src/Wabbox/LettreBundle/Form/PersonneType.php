<?php

namespace Wabbox\LettreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',        'text')
            ->add('prenom',     'text')
            ->add('adresse',    'text')
            ->add('codePostal', 'text')
            ->add('ville',      'text')
            ->add('telephone',  'text')
            ->add('email',  'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wabbox\LettreBundle\Entity\Personne'
        ));
    }

    public function getName()
    {
        return 'wabbox_lettrebundle_personnetype';
    }
}
