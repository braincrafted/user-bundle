<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * InviteQueueUpFormType.
 *
 * @package    BraincraftedUserBundle
 * @subpackage Form.Type
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class RequestInviteFormType extends AbstractType
{
    /** @var string */
    private $class;

    /**
     * Constructor.
     *
     * @param string $class The name of the data class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'request_invite',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'braincrafted_request_invite';
    }
}
