<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as AbstractUser;

/**
 * User
 *
 * @package    BraincraftedUserBundle
 * @subpackage Entity
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class User extends AbstractUser implements \ArrayAccess
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var Invite */
    private $invite;

    /** @var string */
    private $timezone;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

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
     * Sets the first name of the user.
     *
     * @param string $firstName The first name of the user
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Returns the first name of the user.
     *
     * @return string The first name of the user
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the last name of the user.
     *
     * @param string $lastName The last name of the user
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Returns the last name of the user.
     *
     * @return string The last name of the user
     */
    public function getLastName()
    {
        return $this->lastName;
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

    /**
     * Sets the timezone.
     *
     * @param string $timezone The timezone
     *
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Returns the timezone.
     *
     * @return string The timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function offsetSet($key, $value)
    {
        $this->$key = $value;
    }

    public function offsetGet($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
        return null;
    }

    public function offsetExists($key)
    {
        return isset($this->$key);
    }

    public function offsetUnset($key)
    {
        if (isset($this->$key)) {
            $this->$key = null;
        }
    }
}
