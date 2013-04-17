<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use FOS\UserBundle\Model\UserInterface;

/**
 * Invite.
 *
 * @package    BcUserBundle
 * @subpackage Entity
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 *
 * @ORM\Entity
 * @ORM\Table(name="invite")
 */
class Invite
{
    /** @var integer */
    private $id;

    /** @var string */
    private $code;

    /** @string */
    private $email;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     */
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
     * {@inheritDoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    public function send()
    {
        $this->sent = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
