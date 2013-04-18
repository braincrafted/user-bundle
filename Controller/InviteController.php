<?php

namespace Bc\Bundle\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Controller managing the invites
 *
 * @author Florian Eckerstorfer <florian@eckerstorfer.co>
 */
class InviteController extends ContainerAware
{
    public function requestInviteAction()
    {
        $form = $this->container->get('bc_user.request_invite.form');
        $formHandler = $this->container->get('bc_user.request_invite.form.handler');

        $process = $formHandler->process();
        if ($process) {
            $inviteRequest = $form->getData();
            $authUser = true;
            $route = 'bc_user_request_invite_confirmed';

            $this->container->get('bc_bootstrap.flash')->success('You have successfully requested an invite.');

            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            return $response;
        }

        return $this->container->get('templating')->renderResponse(
            'BcUserBundle:Invite:requestInvite.html.'.$this->getEngine(),
            array('form' => $form->createView())
        );
    }

    public function requestInviteConfirmedAction()
    {
        return $this->container->get('templating')->renderResponse(
            'BcUserBundle:Invite:requestInviteConfirmed.html.'.$this->getEngine()
        );
    }


    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }

    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }
}
