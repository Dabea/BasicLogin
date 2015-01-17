<?php

namespace Abe\loginBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abe\loginBundle\Entity\user2;
use Abe\loginBundle\Entity\Role;
use Abe\loginBundle\Form\user2Type;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * user2 controller.
 *
 * @Route("/main/user2")
 */
class user2Controller extends Controller
{

    /**
     * Lists all user2 entities.
     *
     * @Route("/", name="main_user2")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            $this->get('session')->getFlashBag()->add('notice', 'Acess Denied You Must be Admin To view that page');
            return $this->redirect($this->generateUrl('homepage'));
        }
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AbeloginBundle:user2')->findAll();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new user2 entity.
     *
     * @Route("/", name="main_user2_create")
     * @Method("POST")
     * @Template("AbeloginBundle:user2:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new user2();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

      /*  if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('main_user2_show', array('id' => $entity->getId())));
        }
        */
        
        if ($form->isValid()) {
            $data = $form->getData();
            $entity->setUsername($data->getUsername());
            $entity->setPassword($this->encodePassword($entity, $data->getPassword()));
            //$entityManager = $this->getDoctrine()->getManager();
            //$defaultRole = $entityManager->getRepository('AbeloginBundle:Role')->find(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            //$em->setRole($defaultRole);
            $em->flush();

            return $this->redirect($this->generateUrl('main_user2_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a user2 entity.
     *
     * @param user2 $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(user2 $entity)
    {
        $form = $this->createForm(new user2Type(), $entity, array(
            'action' => $this->generateUrl('main_user2_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        
        return $form;
    }

    /**
     * Displays a form to create a new user2 entity.
     *
     * @Route("/new", name="main_user2_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new user2();
        $form   = $this->createCreateForm($entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a user2 entity.
     *
     * @Route("/{id}", name="main_user2_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbeloginBundle:user2')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find user2 entity.');
        }
        $rolecollection = $entity->getRoles();
       // exit(\Doctrine\Common\Util\Debug::dump($rolecollection));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'rolecollection'        => $rolecollection,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing user2 entity.
     *
     * @Route("/{id}/edit", name="main_user2_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbeloginBundle:user2')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find user2 entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a user2 entity.
    *
    * @param user2 $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(user2 $entity)
    {
        $form = $this->createForm(new user2Type(), $entity, array(
            'action' => $this->generateUrl('main_user2_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));
        
        return $form;
    }
    /**
     * Edits an existing user2 entity.
     *
     * @Route("/{id}", name="main_user2_update")
     * @Method("PUT")
     * @Template("AbeloginBundle:user2:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbeloginBundle:user2')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find user2 entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $data = $editForm->getData();
            $user = new user2();
            $user->setUsername($data->getUsername());
            $user->setPassword($this->encodePassword($user, $data->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('main_user2_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a user2 entity.
     *
     * @Route("/{id}", name="main_user2_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AbeloginBundle:user2')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find user2 entity.');
            }
            
            $CurrentUserObj = $this->getUser();
            $CurrentUserId = $CurrentUserObj->getId();
            if($CurrentUserId == $id ) {
                $this->get('session')->getFlashBag()->add('notice', 'You can not Delete your Self from that menu');
                return $this->redirect($this->generateUrl('main_user2'));
            }
            else{
            $em->remove($entity);
            $em->flush();
            }
            
        }

        return $this->redirect($this->generateUrl('main_user2'));
    }

    /**
     * Creates a form to delete a user2 entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('main_user2_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function encodePassword(user2 $user, $Password)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($Password, $user->getSalt());
    }
    
    public function securityadmin()
    {
    $securityContext = $this->container->get('security.context');
    if (!$securityContext->isGranted('ROLE_ADMIN')) {
        $this->get('session')->getFlashBag()->add('notice', 'Acess Denied You Must be Admin To view that page');
        return $this->redirect($this->generateUrl('homepage'));
        
    }
    
    }
}
