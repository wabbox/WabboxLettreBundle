<?php

namespace Wabbox\LettreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Wabbox\LettreBundle\Entity\Contenu;
use Wabbox\LettreBundle\Form\ContenuType;

/**
 * Contenu controller.
 *
 */
class ContenuController extends Controller
{
    /**
     * Lists all Contenu entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WabboxLettreBundle:Contenu')->findAll();

        return $this->render('WabboxLettreBundle:Contenu:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Contenu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxLettreBundle:Contenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WabboxLettreBundle:Contenu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Contenu entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function newAction()
    {
        $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $destinataires = $em->getRepository('WabboxLettreBundle:Personne')->getPersonneUser(false, $user_id);
        $entity = new Contenu();
        $form   = $this->createForm(new ContenuType(), $entity);

        return $this->render('WabboxLettreBundle:Contenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'destinataires' => $destinataires,
        ));
    }

    /**
     * Creates a new Contenu entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function createAction(Request $request)
    {
        $entity  = new Contenu();
        $form = $this->createForm(new ContenuType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenu_show', array('id' => $entity->getId())));
        }

        return $this->render('WabboxLettreBundle:Contenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contenu entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxLettreBundle:Contenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenu entity.');
        }

        $editForm = $this->createForm(new ContenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WabboxLettreBundle:Contenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Contenu entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxLettreBundle:Contenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ContenuType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenu_edit', array('id' => $id)));
        }

        return $this->render('WabboxLettreBundle:Contenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contenu entity.
     *
     */
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WabboxLettreBundle:Contenu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contenu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contenu'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
