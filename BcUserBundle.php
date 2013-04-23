<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 by Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * BcUserBundle
 *
 * @package   BcUserBundle
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class BcUserBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
