<?php 

namespace Abe\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;


Class SecurityController extends Controller
{
    /**
    *   @Route("/login2", name="login_form2")
    *   @Template
    **/
    public function loginAction(Request $request)
    {
         $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return  array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
        );
    }
    
    /**
    * @Route("login_check" , name = "BlackMagic")
    */
    public function logincheckAction()
    {
        //caught by secury componet in symfony
    }
    
    /**
    * @Route ("/logout2" , name="logout2")
    */
    public function logoutAction()
    {
        // Symfony destroyes the session
    }
}