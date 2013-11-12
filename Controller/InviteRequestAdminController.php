<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserAdminBundle\Form\Type\CreateUserType;
use Bc\Bundle\UserAdminBundle\Form\Type\UpdateUserType;
use Bc\Bundle\UserBundle\Entity\User;

/**
 * UserAdminController
 *
 * @category    Controller
 * @package     BcUserBundle
 * @subpackage  Controller
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class InviteRequestAdminController extends Controller
{
    /**
     * List action.
     *
     * @return string The response
     */
    public function listAction()
    {
        $inviteRequestManager = $this->getInviteRequestManager();

        return $this->render('BcUserBundle:InviteRequestAdmin:list.html.twig', array(
            'inviteRequests' => $inviteRequestManager->findInviteRequests()
        ));
    }

    /**
     * Sends an invite to an email address.
     *
     * @param integer $inviteRequestId The ID of the invite request
     *
     * @return Response
     */
    public function inviteAction($inviteRequestId)
    {
        $inviteRequestManager = $this->getInviteRequestManager();
        $inviteManager        = $this->getInviteManager();

        $inviteRequest = $inviteRequestManager->findInviteRequest($inviteRequestId);
        $invite        = $inviteManager->createInvite();

        $invite->setEmail($inviteRequest->getEmail());
        $inviteManager->updateInvite($invite);

        $inviteRequest->delete();
        $inviteRequestManager->updateInviteRequest($inviteRequest);

        return $this->redirect($this->generateUrl('bc_user_admin_invite_request_list'));
    }

    /**
     * @return InviteRequestManager
     */
    private function getInviteRequestManager()
    {
        return $this->get('bc_user.invite_request_manager');
    }

    /**
     * @return InviteManager
     */
    private function getInviteManager()
    {
        return $this->get('bc_user.invite_manager');
    }
}