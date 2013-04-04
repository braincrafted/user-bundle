<?php
/**
 * This file is part of braincrafted/user-bundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * CreateUserType
 *
 * @package     braincrafted/user-bundle
 * @subpackage  Form.Type
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class CreateUserType extends UpdateUserType
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('create'),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'createUser';
    }
}
