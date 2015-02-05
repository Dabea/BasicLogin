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
 * user2 controller.
 *
 * @Route("/main/upload")
 */
class UploadController extends Controller
{   
    /**
     * creates the form to uplaod a file with the Documetn entity entities.
     *
     * @Route("/new", name="main_upload_file")
     * @Method("GET")
     * @Template()
     */
    public function uploadAction()
    {
        
        $entity = new Document();
        $form   = $this->createUploadForm($entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    
    }
    
    /**
    * @Template()
    * @Route("/", name="main_upload")
    * @Method("POST")
    */
   public function uploadFileAction(Request $request)
{
    return $this->redirect($this->generateUrl('homepage'));
    $document = new Document();
    $form = $this->createUploadForm($document);
    $form->handleRequest($request);
    $test =  $form->getErrors();
    
    //if ($this->getRequest()->getMethod() === 'POST') {
      //  $form->bindRequest($this->getRequest());
        if ($form->isSubmitted()) {
            $fileinfomation = $form->getData();
            exit(\Doctrine\Common\Util\Debug::dump($test));
            $em = $this->getDoctrine()->getEntityManager();

            $document->upload();
            
            $em->persist($document);
            $em->flush();
            
            return $this->redirect($this->generateUrl('homepage'));
        }
    //}

    return array(
        'form' => $form->createView(),
        'entity'  =>$document,
        );
}   

     /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createUploadForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'button', array('label' => 'Upload'));

        return $form;
    }

    
    public function upload()
{
    // the file property can be empty if the field is not required
    if (null === $this->getFile()) {
        return;
    }

    // use the original file name here but you should
    // sanitize it at least to avoid any security issues

    // move takes the target directory and then the
    // target filename to move to
    $this->getFile()->move(
        $this->getUploadRootDir(),
        $this->getFile()->getClientOriginalName()
    );

    // set the path property to the filename where you've saved the file
    $this->path = $this->getFile()->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
}

     /**
    * @Template()
    * @Route("/", name="main_uploadfile")
    * @Method("POST")
    */
   public function uploadFileAction2(Request $request)
{
    $document = new Document();
    
    
    $test =  $form->getErrors();
    
    
        if(2) {
            $fileinfomation = $form->getData();
            $em = $this->getDoctrine()->getEntityManager();

            $document->upload();
            
            $em->persist($document);
            $em->flush();
            
            return $this->redirect($this->generateUrl('homepage'));
        }
    }
    
}
