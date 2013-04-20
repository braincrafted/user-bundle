<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserBundle\Entity\InviteRequestManager;
use Bc\Bundle\UserBundle\Entity\InviteRequest;

/**
 * RequestInviteFormHandler
 *
 * @package    BcUserBundle
 * @subpackage FormHandler
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class RequestInviteFormHandler
{
    /** @var Request */
    private $request;

    /** @var InviteRequestManager */
    private $inviteRequestManager;

    /** @var FormInterface */
    private $form;

    /**
     * Constructor
     *
     * @param FormInterface        $form                 The form
     * @param Request              $request              The request
     * @param InviteRequestManager $inviteRequestManager The invite request manager
     */
    public function __construct(FormInterface $form, Request $request, InviteRequestManager $inviteRequestManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->inviteRequestManager = $inviteRequestManager;
    }

    /**
     * Processes the form.
     *
     * @return boolean TRUE if the form was processed successfully, FALSE if not
     */
    public function process()
    {
        $inviteRequest = $this->createInviteRequest();
        $this->form->setData($inviteRequest);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            return $this->validate($inviteRequest);
        }

        return false;
    }

    /**
     * Validates the form.
     *
     * @param InviteRequest $inviteRequest The invite request
     *
     * @return boolean TRUE if the form is valid, FALSE if not.
     */
    private function validate(InviteRequest $inviteRequest)
    {
        if ($this->form->isValid()) {
            $this->onSuccess($inviteRequest);

            return true;
        }

        return false;
    }

    /**
     * Called when the form was processes successfully.
     *
     * @param InviteRequest $inviteRequest The invite request
     *
     * @return void
     */
    private function onSuccess(InviteRequest $inviteRequest)
    {
        $this->inviteRequestManager->updateInviteRequest($inviteRequest);
    }

    /**
     * Creates a new invite request.
     *
     * @return UserInterface
     */
    private function createInviteRequest()
    {
        return $this->inviteRequestManager->createInviteRequest();
    }
}
