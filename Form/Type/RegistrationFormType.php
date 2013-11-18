<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * RegistrationFormType.
 *
 * @package    BraincraftedUserBundle
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
        $builder->add('name', 'braincrafted_name', array(
            'label'                 => 'form.registration.name',
            'translation_domain'    => 'BraincraftedUserBundle'
        ));

        if ($this->inviteRequired) {
            $builder->add('invite', 'braincrafted_invite');
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
        return 'braincrafted_user_registration';
    }
}
