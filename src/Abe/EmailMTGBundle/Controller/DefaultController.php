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
        
        
        /* connect to gmail */
        $hostname = '{imap-mail.outlook.com:993/imap/ssl/novalidate-cert}';
        $username = "";
        $password = '';

        /* try to connect */
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

        /* grab emails */
        $emails = imap_search($inbox,'UNSEEN');
        $emailCollection = array();
        
        foreach($emails as $email_number) {
		
		/* get information specific to this email */
		$overview = imap_fetch_overview($inbox,$email_number,0);
            $emailCollection[] = $overview;
        }
        
        return $this->render('AbeEmailMTGBundle:Default:index.html.twig', 
        
            array(
                'entities' => $entities ,
                'emails' => $emailCollection
                )
           );
    }
}
