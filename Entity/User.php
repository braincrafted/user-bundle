<?php

namespace Bc\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as AbstractUser;

class User extends AbstractUser
{
    /**
     * Returns the ID of the user.
     *
     * @return integer The ID
     */
    public function getId()
    {
        return $this->id;
    }
}
