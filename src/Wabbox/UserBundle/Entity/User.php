<?php
// src/Wabbox/UserBundle/Entity/User.php

namespace Wabbox\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Wabbox\LettreBundle\Entity\Personne;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
    * @ORM\OneToMany(targetEntity="Wabbox\LettreBundle\Entity\Personne", mappedBy="user", orphanRemoval=true, cascade={"all"})
    */
    private $personnes; 
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    public function __construct()
    {
        parent::__construct();
        $this->personnnes = new \Doctrine\Common\Collections\ArrayCollection();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Add personnes
     *
     * @param \Wabbox\LettreBundle\Entity\Personne $personnes
     * @return User
     */
    public function addPersonne(\Wabbox\LettreBundle\Entity\Personne $personnes)
    {
        $this->personnes[] = $personnes;
    
        return $this;
    }

    /**
     * Remove personnes
     *
     * @param \Wabbox\LettreBundle\Entity\Personne $personnes
     */
    public function removePersonne(\Wabbox\LettreBundle\Entity\Personne $personnes)
    {
        $this->personnes->removeElement($personnes);
    }

    /**
     * Get personnes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }
}