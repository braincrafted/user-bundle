<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * InviteRequestManager
 *
 * @package     BcUserBundle
 * @subpackage  Entity
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class InviteRequestManager
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var Doctrine\Common\Persistence\ObjectRepository */
    private $repository;

    /** @var string */
    private $class;

    /**
     * Constructor.
     *
     * @param ObjectManager $objectManager The object manager
     * @param string        $class         The name of the class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $objectManager->getRepository($class);

        $metadata = $objectManager->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Creates a new invite request.
     *
     * @return InviteRequest The new InviteRequest
     */
    public function createInviteRequest()
    {
        return new $this->class();
    }

    /**
     * Returns all invite requests.
     *
     * @return array The list of all invite requests
     */
    public function findInviteRequests()
    {
        return $this->repository->findAll();
    }

    /**
     * Updates the given invite request.
     *
     * @param InviteRequest $inviteRequest The invite request to update
     * @param boolean       $andFlush      If TRUE the operation will be flushed immediately
     *
     * @return void
     */
    public function updateInviteRequest(InviteRequest $inviteRequest, $andFlush = true)
    {
        $inviteRequest->setUpdatedAt(new \DateTime());
        $this->objectManager->persist($inviteRequest);

        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * Flushes the previous operation to the database.
     *
     * @return void
     */
    public function flush()
    {
        $this->objectManager->flush();
    }
}