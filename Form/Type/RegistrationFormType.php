<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * RegistrationFormType.
 *
 * @package    BcUserBundle
 * @subpackage Form.Type
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class RegistrationFormType extends BaseRegistrationFormType
{
    /** @var string */
    private $class;

    /** @var boolean */
    private $inviteRequired;

    /**
     * Constructor
     *
     * @param string  $class          The User class name
     * @param boolean $inviteRequired TRUE if an invite is required for registration
     */
    public function __construct($class, $inviteRequired = false)
    {
        $this->class            = $class;
        $this->inviteRequired   = $inviteRequired;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ($this->inviteRequired) {
            $builder->add('invite', 'bc_invite');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => $this->class,
            'intention'         => 'registration'
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bc_user_registration';
    }
}
