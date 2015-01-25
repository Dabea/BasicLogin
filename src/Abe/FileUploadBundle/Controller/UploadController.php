<?php

namespace Abe\FileUploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * user2 controller.
 *
 * @Route("/main/upload")
 */
class UploadController extends Controller
{   
    /**
     * Lists all user2 entities.
     *
     * @Route("/{name}", name="main_upload")
     * @Method("GET")
     * 
     */
    public function indexAction($name)
    {
        return $this->render('AbeFileUploadBundle:Default:index.html.twig', array('name' => $name));
    }
}
