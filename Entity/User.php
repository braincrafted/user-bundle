<?php
/**
 * This file is part of braincrafted/user-bundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as AbstractUser;

/**
 * User
 *
 * @package     braincrafted/user-bundle
 * @subpackage  Entity
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class User extends AbstractUser
{
    /** @var Invite */
    protected $invite;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->setEnabled(true);
        parent::__construct();
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

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Sets the invite.
     *
     * @param InviteInterf<ace $invite The invite
     *
     * @return User
     */
    public function setInvite(Invite $invite)
    {
        $this->invite = $invite;
        return $this;
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
