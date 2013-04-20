<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer;

/**
 * InviteFormType
 *
 * @package    BcUserBundle
 * @subpackage Form.Type
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class InviteFormType extends AbstractType
{
    /** @var InviteToCodeTransformer */
    private $inviteTransformer;

    /**
     * Constructor.
     *
     * @param InviteToCodeTransformer $inviteTransformer The invite to code transformer
     */
    public function __construct(InviteToCodeTransformer $inviteTransformer)
    {
        $this->inviteTransformer = $inviteTransformer;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this->inviteTransformer, true);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class'         => 'Bc\Bundle\UserBundle\Entity\Invite',
            'required'      => true
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bc_invite';
    }
}
