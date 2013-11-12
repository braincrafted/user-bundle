<?php
/**
 * This file is part of BcUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Bc\Bundle\UserBundle\Form\EventListener\SetNameFieldSubscriber;

/**
 * UpdateUserType
 *
 * @category    FormType
 * @package     BcUserAdminBundle
 * @subpackage  Form
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class UpdateUserType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            'text',
            array('label' => 'form.update_user.username', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'email',
            'text',
            array('label' => 'form.update_user.email', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'plainPassword',
            'password',
            array('label' => 'form.update_user.password', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'name',
            'bc_name',
            array('label' => 'form.update_user.name', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'timezone',
            'timezone',
            array('label' => 'form.update_user.timezone', 'translation_domain' => 'BcUserAdminBundle')
        );
        $builder->add(
            'enabled',
            'checkbox',
            array(
                'label' => 'form.update_user.enabled',
                'translation_domain' => 'BcUserAdminBundle',
                'attr' => array('align_with_widget' => true)
            )
        );
        $builder->add(
            'save',
            'submit',
            array('label' => 'user.update_user', 'translation_domain' => 'BcUserAdminBundle')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('update'),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'updateUser';
    }
}
