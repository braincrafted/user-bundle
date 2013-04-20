<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as AbstractUser;

/**
 * User
 *
 * @package    BcUserBundle
 * @subpackage Entity
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class User extends AbstractUser
{
    /** @var Invite */
    private $invite;

    /**
     * Sets the ID.
     *
     * @param integer $id The ID
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the ID of the user.
     *
     * @return integer The ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the date the user expires at.
     *
     * @return \DateTime The date the user expires at
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Sets the invite.
     *
     * @param InviteInterf<ace $invite The invite
     */
    public function setInvite(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Returns the invite.
     *
     * @return Invite The invite
     */
    public function getInvite()
    {
        return $this->invite;
    }
}
