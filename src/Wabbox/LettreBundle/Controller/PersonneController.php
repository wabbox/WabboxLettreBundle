<?php
// src/Wabbox/LettreBundle/Controller/PersonneController.php

namespace Wabbox\LettreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Wabbox\LettreBundle\Entity\Personne;
use Wabbox\LettreBundle\Form\PersonneType;

/**
 * Personne controller.
 *
 */
class PersonneController extends Controller
{
    /**
     * Lists all Personne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $entities = $em->getRepository('WabboxLettreBundle:Personne')->getPersonneUser(false, $user_id);

        return $this->render('WabboxLettreBundle:Personne:index.html.twig', array(
            'entities' => $entities,
            ));
    }

    /**
     * Finds and displays a Personne entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxLettreBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver L\'entité personne.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WabboxLettreBundle:Personne:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Personne entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function newAction($personne_type)
    {
        if ($personne_type == 'expediteur') {
            $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
            
            $em = $this->getDoctrine()->getManager();
            $test_entity = $em->getRepository('WabboxLettreBundle:Personne')->getPersonneUser(true, $user_id);
            if ($test_entity) {
                throw $this->createNotFoundException('Information expéditeur déjà remplis.');
            }
        }
        $entity = new Personne();
        $form   = $this->createForm(new PersonneType(), $entity);

        return $this->render('WabboxLettreBundle:Personne:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'personne_type'   => $personne_type,
            ));
    }

    /**
     * Creates a new Personne entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function createAction(Request $request,$personne_type)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $entity  = new Personne();
        $form = $this->createForm(new PersonneType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            if ($personne_type == 'expediteur') {
                $user_id = $user->getId();
                
                $em = $this->getDoctrine()->getManager();
                $test_entity = $em->getRepository('WabboxLettreBundle:Personne')->getPersonneUser(true, $user_id);
                if ($test_entity) {
                    throw $this->createNotFoundException('Information expéditeur déjà remplis.');
                }
                $entity->setExpediteur(true);
            }
            
            $entity->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('wabbox_lettre_new'));
        }

        return $this->render('WabboxLettreBundle:Personne:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'personne_type'   => $personne_type,
            ));
    }

    /**
     * Displays a form to edit an existing Personne entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxLettreBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        $editForm = $this->createForm(new PersonneType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WabboxLettreBundle:Personne:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            ));
    }

    /**
     * Edits an existing Personne entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxLettreBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PersonneType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('personne_edit', array('id' => $id)));
        }

        return $this->render('WabboxLettreBundle:Personne:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            ));
    }

    /**
     * Deletes a Personne entity.
     *
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('WabboxLettreBundle:Personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personne entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('contenu_new'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
        ->add('id', 'hidden')
        ->getForm()
        ;
    }
}
