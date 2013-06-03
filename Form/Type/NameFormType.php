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
use Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer;

/**
 * NameFormType
 *
 * @package    BcUserBundle
 * @subpackage Form.Type
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class NameFormType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstName',
            'text',
            array(
                'translation_domain'            => 'BcUserBundle',
                'attr' => array('placeholder'   => 'form.name.first_name')
            )
        );
        $builder->add(
            'lastName',
            'text',
            array(
                'translation_domain'            => 'BcUserBundle',
                'attr' => array('placeholder'   => 'form.name.last_name')
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'virtual' => true
        ));
    }


    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bc_name';
    }
}
