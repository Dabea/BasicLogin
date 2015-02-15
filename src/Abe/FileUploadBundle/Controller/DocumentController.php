<?php

namespace Abe\FileUploadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abe\FileUploadBundle\Entity\Document;
use Abe\FileUploadBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{

    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AbeFileUploadBundle:Document')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Document entity.
     *
     * @Route("/", name="document_create")
     * @Method("POST")
     * @Template("AbeFileUploadBundle:Document:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $document = new Document();
        $form = $this->createCreateForm($document);
    
    
    
    if ($this->getRequest()->getMethod() === 'POST') {
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $fileinfomation = $form->getData();
            
            $em = $this->getDoctrine()->getEntityManager();
            $currentUser = $this->getUser();
            $document->upload($currentUser);
            
            $em->persist($document);
            $em->flush();
            
            return $this->redirect($this->generateUrl('homepage'));
        }
    }

    return array(
        'entity'  =>$document,
        'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_create'),
            'method' => 'POST',
        ));
        
        $form
            ->add('file' ,'file')
            ->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="document_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Document();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}", name="document_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbeFileUploadBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }



    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AbeFileUploadBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('document'));
    }

    /**
     * Creates a form to delete a Document entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    

    
    
    
    
    
}
