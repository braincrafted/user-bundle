<?php
/**
 * This file is part of BcUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * CreateUserType
 *
 * @category    FormType
 * @package     BcUserAdminBundle
 * @subpackage  Form
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class CreateUserType extends UpdateUserType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->remove('save');
        $builder->add(
            'save',
            'submit',
            array('label' => 'user.create_user', 'translation_domain' => 'BcUserAdminBundle')
        );
    }

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
