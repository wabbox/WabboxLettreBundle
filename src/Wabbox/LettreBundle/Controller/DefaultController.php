<?php
// src/Wabbox/LettreBundle/Controller/DefaultController.php
namespace Wabbox\LettreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wabbox\LettreBundle\Entity\Personne;
use Wabbox\LettreBundle\Form\PersonneType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $user->getId();
        $expediteur = new Personne();
        $form_expediteur   = $this->createForm(new PersonneType(), $expediteur);

        $destinataire = new Personne();
        $form_destinataire   = $this->createForm(new PersonneType(), $destinataire);

        return $this->render('WabboxLettreBundle:Default:index.html.twig', array(
            'expediteur'        => $expediteur,                     
            'form_expediteur'   => $form_expediteur->createView(),  
            'destinataire'      => $destinataire,                   
            'form_destinataire' => $form_destinataire->createView(),
            ));
    }
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function newAction()
    {
        $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $testExpediteur = $em->getRepository('WabboxLettreBundle:Personne')->getPersonneUser(true, $user_id);
        $destinataires = $em->getRepository('WabboxLettreBundle:Personne')->getPersonneUser(false, $user_id);
        if (!$testExpediteur) {
            $personne_type = 'expediteur';
            $personne = new Personne();
            $form   = $this->createForm(new PersonneType(), $personne);

            return $this->render('WabboxLettreBundle:Personne:new.html.twig', array(
                'entity'        => $personne,          
                'form'          => $form->createView(),
                'personne_type' => $personne_type,     
                ));
        }
        $expediteur = $em->getRepository('WabboxLettreBundle:Personne')->getExpediteur($user_id);
        $editExpediteur = $this->createForm(new PersonneType(), $expediteur);
        return $this->render('WabboxLettreBundle:Default:new.html.twig', array(
            'expediteur'    => $expediteur,                     
            'destinataires' => $destinataires,                   
            'edit_form'     => $editExpediteur->createView(),
            ));

    }
    public function update_expediteurAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $expediteur = $em->getRepository('WabboxLettreBundle:Personne')->find($id);

        if (!$expediteur) {
            throw $this->createNotFoundException('Unable to find Personne expediteur.');
        }

        $editForm = $this->createForm(new PersonneType(), $expediteur);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($expediteur);
            $em->flush();

            $expediteurHTML = $this->renderView('WabboxLettreBundle:Default:expediteur.html.twig', array('expediteur' => $expediteur));
            if($request->isXmlHttpRequest())
            {
                return new JsonResponse(array('expediteurHTML' => $expediteurHTML));
            }
            
                /*$response = new Response(json_encode(array('expediteurHTML' => $expediteurHTML)));
                $response->headers->set('Content-Type', 'application/json');
                 
                return $response;*/
            }

            return $this->render('WabboxLettreBundle:Personne:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                ));
        }
        public function voirAction($id_expediteur, $id_destinataire)
        {
            $em = $this->getDoctrine()->getManager();

            $expediteur = $em->getRepository('WabboxLettreBundle:Personne')->find($id_expediteur);
            $destinataire = $em->getRepository('WabboxLettreBundle:Personne')->find($id_destinataire);

            if (!$expediteur) {
                throw $this->createNotFoundException('Entity expediteur non trouver.');
            }

            if (!$destinataire) {
                throw $this->createNotFoundException('Entity destinataire non trouver.');
            }

            return $this->render('WabboxLettreBundle:Default:voir.html.twig', array(
                'expediteur'   => $expediteur,     
                'destinataire' => $destinataire,
                ));
        }
    }