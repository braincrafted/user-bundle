<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bc\Bundle\UserBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserBundle\Entity\InviteRequestManager;
use Bc\Bundle\UserBundle\Entity\InviteRequest;

class RequestInviteFormHandler
{
    protected $request;
    protected $inviteRequestManager;
    protected $form;

    public function __construct(FormInterface $form, Request $request, InviteRequestManager $inviteRequestManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->inviteRequestManager = $inviteRequestManager;
    }

    /**
     */
    public function process()
    {
        $inviteRequest = $this->createInviteRequest();
        $this->form->setData($inviteRequest);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($inviteRequest);

                return true;
            }
        }

        return false;
    }

    /**
     */
    protected function onSuccess(InviteRequest $inviteRequest)
    {
        $this->inviteRequestManager->updateInviteRequest($inviteRequest);
    }

    /**
     * @return UserInterface
     */
    protected function createInviteRequest()
    {
        return $this->inviteRequestManager->createInviteRequest();
    }
}
