<?php
/**
 * This file is part of BraincraftedUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use Braincrafted\Bundle\UserBundle\Entity\Invite;

/**
 * InviteManager.
 *
 * @package    BraincraftedUserBundle
 * @subpackage EntityManager
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class InviteManager
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var ObjectRepository */
    protected $repository;

    /**
     * Constructor.
     *
     * @param ObjectManager $om The object manager
     *
     * @return void
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager    = $om;
        $this->repository       = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Returns the name of the managed class.
     *
     * @return string The class name
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Creates a new invite.
     *
     * @return InviteInterface The invite
     */
    public function createInvite()
    {
        $class = $this->getClass();
        $invite = new $class;

        return $invite;
    }

    /**
     * Finds all invites.
     *
     * @return mixed The invites
     */
    public function findInvites()
    {
        return $this->repository->findBy(array(), array('updatedAt' => 'DESC'));
    }

    /**
     * Finds one invite by its code.
     *
     * @param string $code The code
     *
     * @return InviteInterface The invite
     */
    public function findInviteByCode($code)
    {
        return $this->repository->findOneBy(array(
            'code' => $code
        ));
    }

    public function getUsedInvitesCount()
    {
        $result = $this->objectManager->createQueryBuilder()
            ->select('count(u.invite) AS used')
            ->from('BraincraftedUserBundle:User', 'u')
            ->where('u.invite IS NOT NULL')
            ->getQuery()
            ->getSingleResult()
        ;

        return $result['used'];
    }

    public function getSentInvitesCount()
    {
        $result = $this->objectManager->createQueryBuilder()
            ->select('count(i.code) as sent')
            ->from('BraincraftedUserBundle:Invite', 'i')
            ->where('i.sent = true')
            ->getQuery()
            ->getSingleResult()
        ;

        return $result['sent'];
    }

    /**
     * Deletes the given invite.
     *
     * @param InviteInterface $invite The invite
     *
     * @return void
     */
    public function deleteInvite(Invite $invite)
    {
        $this->objectManager->remove($invite);
        $this->objectManager->flush();
    }

    /**
     * Updates the given invite.
     *
     * @param Invite $invite The invite
     * @param boolean    $andFlush   If TRUE transaction will be flushed to database
     *
     * @return void
     */
    public function updateInvite(Invite $invite, $andFlush = true)
    {
        $invite->setUpdatedAt(new \DateTime());
        $this->objectManager->persist($invite);

        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * Flushes to the database.
     *
     * @return void
     */
    public function flush()
    {
        $this->objectManager->flush();
    }

    public function getInviteCount()
    {
        $result = $this->objectManager->createQueryBuilder()
            ->select('count(i.code) AS total')
            ->from('BraincraftedUserBundle:Invite', 'i')
            ->getQuery()
            ->getSingleResult()
        ;

        return $result['total'];
    }
}
