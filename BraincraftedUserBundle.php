<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 by Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * BraincraftedUserBundle
 *
 * @package   BraincraftedUserBundle
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class BraincraftedUserBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
