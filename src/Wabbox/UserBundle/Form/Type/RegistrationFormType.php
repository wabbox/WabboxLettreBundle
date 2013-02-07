<?php
// src/Wabbox/UserBundle/Form/Type/RegistrationFormType.php

namespace Wabbox\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Wabbox\LettreBundle\Form\PersonneType;
//use Wabbox\LettreBundle\Entity\Personne;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        //$builder->add('personne',  new PersonneType());
    }

    public function getName()
    {
        return 'wabbox_user_registration';
    }
}