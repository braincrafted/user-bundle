<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\UserInterface;

/**
 * Invite.
 *
 * @package    BcUserBundle
 * @subpackage Entity
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class Invite
{
    /** @var integer */
    private $id;

    /** @var string */
    private $code;

    /** @string */
    private $email;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /**
     * When sending invite be sure to set this value to `true`
     *
     * It can prevent invites from being sent twice
     *
     * @var boolean
     */
    private $sent = false;

    /** @var User */
    private $user;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        // generate identifier only once, here a 6 characters length code
        $this->code = substr(md5(uniqid(rand(), true)), 0, 6);
    }

    /**
     * Returns the invitation code.
     *
     * @return string The code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the email address of the invite.
     *
     * @param string $email The email address
     *
     * @return Invite
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Returns the email address.
     *
     * @return string The email address
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the send flag to <code>TRUE</code>.
     *
     * @return Invite
     */
    public function send()
    {
        $this->sent = true;

        return $this;
    }

    /**
     * Returns if the send flag is set to <code>TRUE</code>.
     *
     * @return boolean TRUE if the invite was sent
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * Sets the user associated with the invite.
     *
     * @param UserInterface $user The user
     *
     * @return Invite
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Retursn the user associated with the invite.
     *
     * @return UserInterface The user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the date the invite was created at.
     *
     * @param \DateTime $createdAt The date the invite was created.
     *
     * @return Invite
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the date the invite was created at.
     *
     * @return \DateTime The date the invite was created at
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the date the invite was last updated at.
     *
     * @param \DateTime $updatedAt The date the invite was last updated at.
     *
     * @return Invite
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the date the invite was last updated at.
     *
     * @return \DateTime The date the invite was last updated at
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
