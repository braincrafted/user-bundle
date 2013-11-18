<?php
/**
 * This file is part of BraincraftedUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * InviteController.
 *
 * @category   Controller
 * @package    BraincraftedUserBundle
 * @subpackage Controller
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class InviteAdminController extends Controller
{
    /**
     * List action.
     */
    public function listAction()
    {
        $manager = $this->get('braincrafted_user.invite_manager');

        $invites = $manager->findInvites();

        $totalCount = $manager->getInviteCount();
        $usedCount = $manager->getUsedInvitesCount();
        $sentCount = $manager->getSentInvitesCount();

        $usedInvitesPercentage = 0;
        $sentInvitesPercentage = 0;
        if ($totalCount > 0) {
            $usedInvitesPercentage = (100/$totalCount)*$usedCount;
            $sentInvitesPercentage = (100/$totalCount)*($sentCount);
        }

        return $this->render('BraincraftedUserBundle:InviteAdmin:list.html.twig', array(
            'invites'                   => $invites,
            'usedInvitesPercentage'     => $usedInvitesPercentage,
            'sentInvitesPercentage'     => $sentInvitesPercentage,
            'usedInvitesCount'          => $usedCount,
            'sentInvitesCount'          => $sentCount
        ));
    }

    /**
     * Create action.
     */
    public function createAction()
    {
        $manager = $this->get('braincrafted_user.invite_manager');
        $invite = $manager->createInvite();
        $manager->updateInvite($invite);

        $this->get('session')->getFlashBag()->add('success', sprintf('The invite %s has been created.', $invite->getCode()));

        return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
    }

    /**
     * Batch create action.
     *
     * @param integer $number The number of invites to create
     */
    public function batchCreateAction($number)
    {
        $manager = $this->get('braincrafted_user.invite_manager');
        for ($i = 0; $i < $number; $i++) {
            $invite = $manager->createInvite();
            $manager->updateInvite($invite, false);
        }
        $manager->flush();

        $this->get('session')->getFlashBag()->add('success', sprintf('Created %d invites.', $number));
        return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
    }

    /**
     * Delete action.
     *
     * @param string $code The code of the invite
     */
    public function deleteAction($code)
    {
        $manager = $this->get('braincrafted_user.invite_manager');
        $invite = $manager->findInviteByCode($code);

        if (!$invite) {
            $this->get('session')->getFlashBag()->add('error', sprintf('The invite %s does not exist.', $code));
            return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
        }

        if ($invite->getUser()) {
            $this->get('session')->getFlashBag()->add('error', sprintf('The invite %s has already been used by %s. You can\'t delete an used invite.', $invite->getCode(), $invite->getUser()));
            return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
        }

        $manager->deleteInvite($invite);

        $this->get('session')->getFlashBag()->add('success', sprintf('The invite %s has been deleted.', $invite->getCode()));

        return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
    }

    /**
     * Sends the given invite to an email address.
     *
     * @param string $code The invite code
     */
    public function sendAction($code)
    {
        $manager = $this->get('braincrafted_user.invite_manager');
        $invite = $manager->findInviteByCode($code);

        if (!$invite) {
            $this->get('braincrafted_bootstrap.flash')->error(sprintf('The invite %s does not exist.', $code));

            return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
        }

        if (!$invite->getEmail()) {
            $this->get('braincrafted_bootstrap.flash')->error(sprintf('The invite %s does not have an email address associated and can\'t be sent.', $code));

            return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
        }

        if ($invite->getUser()) {
            $this->get('braincrafted_bootstrap.flash')->error(sprintf('The invite %s has already been used by %s. You can\'t send an used invite.', $invite->getCode(), $invite->getUser()));

            return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
        }

        if ($invite->isSent()) {
            $this->get('braincrafted_bootstrap.flash')->error(sprintf('The invite %s has already been sent to the email address %s. You can\'t send an used invite.', $invite->getCode(), $invite->getEmail()));

            return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
        }

        $message = \Swift_Message::newInstance()
                ->setSubject('Invite for BraincraftedUserAdmin')
                ->setFrom('useradmin@braincrafted.com')
                ->setTo($invite->getEmail())
                ->setBody(
                    $this->renderView(
                        'BraincraftedUserBundle:Email:invite.txt.twig',
                        array(
                            'email' => $invite->getEmail(),
                            'code'  => $invite->getCode()
                        )
                    )
                )
            ;
        $this->get('mailer')->send($message);

        $invite->send();
        $manager->updateInvite($invite);

        $this->get('braincrafted_bootstrap.flash')->success(sprintf('The invite %s has been sent to %s.', $invite->getCode(), $invite->getEmail()));

        return $this->redirect($this->generateUrl('braincrafted_user_admin_invite_list'));
    }
}
