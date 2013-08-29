<?php

namespace SM\Bundle\AdminBundle\Controller;

use SM\Bundle\AdminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * SecurityController
 */
class SecurityController extends Controller
{
    /**
     * indexAction
     *
     * @return type
     */
    public function indexAction()
    {
        return $this->render('SMAdminBundle:Security:index.html.twig');
    }

    /**
     * loginAction
     *
     * @return type
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

//        if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
//            $refererUri = $request->server->get('HTTP_REFERER');
//
//            return new RedirectResponse($refererUri && $refererUri != $request->getUri() ? $refererUri : $this->container->get('router')->generate('admin_user'));
//        }

        return $this->render(
            'SMAdminBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }

    /**
     * checkAction
     * 
     * @throws \RuntimeException
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
}
