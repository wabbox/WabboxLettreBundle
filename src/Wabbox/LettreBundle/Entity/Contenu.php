<?php

namespace Wabbox\LettreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contenu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wabbox\LettreBundle\Entity\ContenuRepository")
 */
class Contenu
{
    
    /**
    * @ORM\ManyToOne(targetEntity="Wabbox\LettreBundle\Entity\Personne", inversedBy="contenus")
    * @ORM\JoinColumn(nullable=false)
    */
    private $personne;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var datetime $date
    *
    * @ORM\Column(name="date", type="datetime")
    */
    private $date;
  
    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank()
     */
    private $message;

    public function __construct()
    {
       $this->date = new \Datetime; 
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
     * Set objet
     *
     * @param string $objet
     * @return Contenu
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
    
        return $this;
    }

    /**
     * Get objet
     *
     * @return string 
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Contenu
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Contenu
     */
    public function setDate(\Datetime $date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set personne
     *
     * @param \Wabbox\LettreBundle\Entity\Personne $personne
     * @return Contenu
     */
    public function setPersonne(\Wabbox\LettreBundle\Entity\Personne $personne)
    {
        $this->personne = $personne;
    
        return $this;
    }

    /**
     * Get personne
     *
     * @return \Wabbox\LettreBundle\Entity\Personne 
     */
    public function getPersonne()
    {
        return $this->personne;
    }
}