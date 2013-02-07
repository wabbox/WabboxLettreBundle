<?php

namespace Wabbox\CvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Wabbox\CvBundle\Entity\Contact;
use Wabbox\CvBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    /**
     * Lists all Contact entities.
     *
     */
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WabboxCvBundle:Contact')->findAll();

        return $this->render('WabboxCvBundle:Contact:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     */
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxCvBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WabboxCvBundle:Contact:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     */
    public function newAction()
    {
        $entity = new Contact();
        $form   = $this->createForm(new ContactType(), $entity);

        return $this->render('WabboxCvBundle:Contact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Contact entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Contact();
        $form = $this->createForm(new ContactType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        // On envoie le mail
            $mailer = $this->get('mailer');
            $message = \Swift_Message::newInstance()
                        ->setSubject($entity->getObjet())
                        ->setFrom($entity->getEmail())
                        ->setTo('perrin.gontran@gmail.com')
                        ->setBody($entity->getMessage());
                $type = $message->getHeaders()->get('Content-Type');
                $type->setValue('text/html');
                $type->setParameter('charset', 'utf-8');
                $mailer->send($message);
            return $this->redirect($this->generateUrl('wabbox_cv_homepage'));
            //return $this->redirect($this->generateUrl('contact_show', array('id' => $entity->getId())));
        }

        return $this->render('WabboxCvBundle:Contact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     */
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxCvBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WabboxCvBundle:Contact:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Contact entity.
     *
     */
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WabboxCvBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ContactType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contact_edit', array('id' => $id)));
        }

        return $this->render('WabboxCvBundle:Contact:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contact entity.
     *
     */
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function deleteAction($id)
    {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WabboxCvBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('contact_list'));
    }
    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
