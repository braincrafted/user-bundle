<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * InviteQueueUpFormType.
 *
 * @package    BcUserBundle
 * @subpackage Form.Type
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class RequestInviteFormType extends AbstractType
{
    /** @var string */
    private $class;

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
        return 'bc_request_invite';
    }
}
