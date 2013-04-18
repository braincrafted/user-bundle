<?php

namespace Bc\Bundle\UserBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class InviteRequestManager
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var string */
    private $class;

    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
    }

    public function createInviteRequest()
    {
        return new $this->class();
    }

    public function updateInviteRequest(InviteRequest $inviteRequest, $andFlush = true)
    {
        $inviteRequest->setUpdatedAt(new \DateTime());
        $this->objectManager->persist($inviteRequest);

        if ($andFlush) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}