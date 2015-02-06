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
        if ($securityContext->isGranted('ROLE_TEST') or $securityContext->isGranted('ROLE_ADMIN') ) {
            $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AbeloginBundle:user2')->findAll();
        return array(
            'entities' => $entities,
            );
        }
        else {
        $this->get('session')->getFlashBag()->add('notice', 'Acess Denied You Must be Admin To view that page');
            return $this->redirect($this->generateUrl('homepage'));
        }
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

        if($form->isValid()) {
            $data = $form->getData();
            $entity->setUsername($data->getUsername());
            $plainPassword = $data->getplainPassword();
            $entity->setPassword($this->encodePassword($entity, $plainPassword));
            $entityManager = $this->getDoctrine()->getManager();
            $defaultRole = $entityManager->getRepository('AbeloginBundle:Role')->find(0);
            $entity->addRole($defaultRole);
            $entityManager->persist($entity);
            //exit(\Doctrine\Common\Util\Debug::dump($data));
            $entityManager->flush();
            
            $securityContext = $this->container->get('security.context');
            if(!$securityContext->isGranted('ROLE_USER')) {
                $this->get('session')->getFlashBag()->add('registered', 'Registration Successful Please Login');
                return $this->redirect($this->generateUrl('login'));
            }else{
                //return $this->redirect($this->generateUrl('main_user2_show', array('id' => $entity->getId())));
            }
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
        $deleteForm = $this->createDeleteForm($id);
        $grantAdminForm = $this->createGrantAdminForm($id);
        $removeAdminForm = $this->createRemoveAdminForm($id);
        $roleForm = $this->createRolesForm($id);

        return array(
            'entity'          => $entity,
            'rolecollection'  => $rolecollection,
            'delete_form'     => $deleteForm->createView(),
            'grantAdmin_form' => $grantAdminForm->createView(),
            'removeAdmin_form'=> $removeAdminForm->createView(),
            'Roles_form'      => $roleForm->createView(),
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
        $rolecollection = $entity->getRoles();
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $grantAdminForm = $this->createGrantAdminForm($id);
        $removeAdminForm = $this->createRemoveAdminForm($id);

        return array(
            'entity'      => $entity,
            'rolecollection'  => $rolecollection,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'grantAdmin_form' => $grantAdminForm->createView(),
            'removeAdmin_form' => $removeAdminForm->createView(),
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
        $grantAdminForm = $this->createGrantAdminForm($id);
        $rolecollection = $entity->getRoles();

        if ($editForm->isValid()) {
            $data = $editForm->getData();
            $plainPassword = $data->getplainPassword();
            $entity->setUsername($data->getUsername());
            if(!empty($plainPassword)){
            $entity->setPassword($this->encodePassword($entity, $plainPassword));
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('main_user2_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'rolecollection'  => $rolecollection,
            'grantAdmin_form' => $grantAdminForm->createView(),
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
     
    /**
     * Grants Admin status to a user2 entity.
     *
     * @Route("grant/{id}", name="main_user2_grant_admin")
     * @Method("PUT")
     */
    public function grantAdmin(Request $request, $id)
    {
        $form = $this->createGrantAdminForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entity = $entityManager->getRepository('AbeloginBundle:user2')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find user2 entity.');
            }
            
            $securityContext = $this->container->get('security.context');
            if (!$securityContext->isGranted('ROLE_ADMIN')){
                $this->get('session')->getFlashBag()->add('notice', 'You do not have enough access to grant admin status');
                return $this->redirect($this->generateUrl('homepage'));
            }
            else{
           $adminRole = $entityManager->getRepository('AbeloginBundle:Role')->find(2);
           $entity->addRole($adminRole);
           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
           $em->flush();
            }
            
        }

        return $this->redirect($this->generateUrl('main_user2'));
    }
    
    /**
     * Creates a form to grant admin status a user2 entity by id.
     *
     * @param mixed $id The entity id
     *
     * 
     */
    private function createGrantAdminForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('main_user2_grant_admin', array('id' => $id)))
            ->setMethod('PUT')
            ->add('submit', 'submit', array('label' => 'Grant Admin'))
            ->getForm()
        ;
    }
    
    /**
     * Removes Admin status to a user2 entity.
     *
     * @Route("Remove/{id}", name="main_user2_remove_admin")
     * @Method("PUT")
     */
    public function RemoveAdmin(Request $request, $id)
    {
        $form = $this->createRemoveAdminForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entity = $entityManager->getRepository('AbeloginBundle:user2')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find user2 entity.');
            }
            
            $securityContext = $this->container->get('security.context');
            if (!$securityContext->isGranted('ROLE_ADMIN')){
                $this->get('session')->getFlashBag()->add('notice', 'You do not have enough access to remove admin status');
                return $this->redirect($this->generateUrl('homepage'));
            }
            else{
           $adminRole = $entityManager->getRepository('AbeloginBundle:Role')->find(2);
           $entity->removeRole($adminRole);
           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
           $em->flush();
            }
            
        }

        return $this->redirect($this->generateUrl('main_user2'));
    }
    
    /**
     * Creates a form to grant admin status a user2 entity by id.
     *
     * @param mixed $id The entity id
     *
     * 
     */
    private function createRemoveAdminForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('main_user2_remove_admin', array('id' => $id)))
            ->setMethod('PUT')
            ->add('submit', 'submit', array('label' => 'Remove Admin'))
            ->getForm()
        ;
    }
    
    
    /**
     * Creates a form to change roles on user2 entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRolesForm($id)
    {
        
        //Put Logic in here to generate the Roles for the roles form and have the two lists compare against the other entity so 
        // that if current roles has the value then it will not be in Aviable Roles
        $entityManager = $this->getDoctrine()->getManager();
        $roles = $entityManager->getRepository('AbeloginBundle:user2')->find($id);
        $aviableRolesObj = $entityManager->getRepository('AbeloginBundle:Role')->findAll();
        $aviableRoles = array();
        foreach($aviableRolesObj as $name =>$value){
           $aviableRoles [] .= $value;
        }
        $currnetRolesObj = $roles->getRoles();
        $currnetRoles = array();
        foreach($currnetRolesObj as $name =>$value){
            $currnetRoles[] .= $value;
        }
        $userAviableRoles = array_diff($aviableRoles ,$currnetRoles  );
            //exit(\Doctrine\Common\Util\Debug::dump($userAviableRoles));
            
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('main_user2_roles_update', array('id' => $id)))
            ->setMethod('PUT')
            ->add('Current_Roles', 'choice', array(
                'choices' => $currnetRoles,
                'data' => $currnetRoles,
                'expanded' => false,
                'multiple' => true,
                'required'    => false,)
                )
            ->add('Aviable_Roles', 'choice', array(
                'choices' => $userAviableRoles,
                'expanded' => false,
                'multiple' => true,
                'required'    => false,
                'empty_data'  => null)
                )                       
            ->add('add', 'submit', array('label' => 'Add Roles'))
            ->add('remove', 'submit', array('label' => 'Remove Roles'))
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to edit Roles in an existing user2 entity.
     *
     * @Route("/roles/{id}", name="main_user2_roles")
     * @Method("GET")
     * @Template()
     */
    public function ChangeRolesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AbeloginBundle:user2')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find user2 entity.');
        }
        $rolecollection = $entity->getRoles();
        $roleForm = $this->createRolesForm($id);
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $grantAdminForm = $this->createGrantAdminForm($id);
        $removeAdminForm = $this->createRemoveAdminForm($id);

        return array(
            'entity'      => $entity,
            'rolecollection'  => $rolecollection,
            'Roles_form'      => $roleForm->createView(),
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'grantAdmin_form' => $grantAdminForm->createView(),
            'removeAdmin_form' => $removeAdminForm->createView(),
        );
    }
    
    /**
     * Updates Admin status to a user2 entity.
     *
     * @Route("/updateroles/{id}", name="main_user2_roles_update")
     * @Method("PUT")
     * @Template()
     */
    public function UpdateRolesAction(Request $request, $id)
    {
        $form = $this->createRolesForm($id);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AbeloginBundle:user2')->find($id);

        $currentRoles = array();
        $currentRolesObj = $entity->getRoles();
        foreach($currentRolesObj as $name =>$value){
                $currentRoles[] .= $value;
            }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find user2 entity.');
        } 
        $securityContext = $this->container->get('security.context');
        if(($securityContext->isGranted('ROLE_ADMIN'))  || $securityContext->isGranted('ROLE_TEST')){
           $data = $form->get('Aviable_Roles')->getData();
           $curentdata = $form->get('Current_Roles')->getData();
           $entityManager = $this->getDoctrine()->getManager();
           if ($form->isValid()) {
                if(!$securityContext->isGranted('ROLE_ADMIN')){
                    $this->get('session')->getFlashBag()->add('notice', 'You do not have enough access to remove admin status');
                    return $this->redirect($this->generateUrl('homepage'));
                }else{
                    if ($form->get('add')->isClicked()) {
                        foreach($data as $key =>$selectedRoles){
                                $adminRole = $entityManager->getRepository('AbeloginBundle:Role')->find($selectedRoles);
                                $entity->addRole($adminRole);
                                $em->persist($entity);                        
                        }
                    }
                    if($form->get('remove')->isClicked()) {
                        $CurrentUserObj = $this->getUser();
                        $CurrentUserId = $CurrentUserObj->getId();
                        
                        
                            foreach($curentdata as $key =>$selectedRoles){
                                    $adminRole = $entityManager->getRepository('AbeloginBundle:Role')->findOneByrole($currentRoles[$selectedRoles]);
                                    
                                    if($CurrentUserId == $id){
                                        if(($selectedRoles == 1) && (sizeof($curentdata) <= 1) ){
                                            $this->get('session')->getFlashBag()->add('notice', 'You can not remove ROLE_ADMIN from your self');
                                        }elseif( ($selectedRoles == 1) && (sizeof($curentdata) > 1)){
                                            $this->get('session')->getFlashBag()->add('notice', 'You can not remove ROLE_ADMIN from your self But all other role changes were completed successfully');
                                        }
                                    }
                                    if($selectedRoles != 0){
                                        $entity->removeRole($adminRole);
                                     $em->persist($entity);  
                                    }
                                    if(($selectedRoles == 0) && (sizeof($curentdata) <= 1) ){
                                        $this->get('session')->getFlashBag()->add('notice', 'All users must have ROLE_USER');
                                    }elseif( ($selectedRoles == 0) && (sizeof($curentdata) > 1)){
                                        $this->get('session')->getFlashBag()->add('notice', 'All users must have ROLE_USER But all other role changes were completed successfully');
                                    }
                            }
                        
                    }
                    $em->flush();
                    return $this->redirect($this->generateUrl('main_user2', array('id' => $id)));
                }
            }
        }else{
            $this->get('session')->getFlashBag()->add('notice', 'You do not have enough access to remove admin status');
            return $this->redirect($this->generateUrl('homepage'));
        }
        $rolecollection = $entity->getRoles();
        $roleForm = $this->createRolesForm($id);
            
            return array(
            'entity'          => $entity,
            'Roles_form'      => $roleForm->createView()
        );
    }
  
    
}
 