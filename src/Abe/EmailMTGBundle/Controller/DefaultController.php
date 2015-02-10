<?php

namespace Abe\EmailMTGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abe\EmailMTGBundle\Entity\emailInfo;

/**
 * Default controller.
 *
 * @Route("/main/email")
 */
class DefaultController extends Controller
{
    /**
     * Lists all Document entities.
     *
     * @Route("/", name="email_MTG")
     * @Template()
     */
    public function indexAction()
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $entities = $entityManager->getRepository('AbeEmailMTGBundle:emailInfo')->findAll();
        
        return $this->render('AbeEmailMTGBundle:Default:index.html.twig', 
        
            array('entities' => $entities)
           );
    }
}
