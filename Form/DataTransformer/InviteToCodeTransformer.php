<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Form\DataTransformer;

use Braincrafted\Bundle\UserBundle\Entity\Invite;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms an Invite to an invitation code.
 *
 * @package    BraincraftedUserBundle
 * @subpackage Form.DataTransformer
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 */
class InviteToCodeTransformer implements DataTransformerInterface
{
    /** @var EntityManager */
    private $objectManager;

    /**
     * Constructor.
     *
     * @param ObjectManager $objectManager The entity manager.
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Transforms the given invitation into the invitation code.
     *
     * @param Invite $value The invitation
     *
     * @return string The invitation code
     *
     * @throws UnexpectedTypeException when $value is not an instance of Invite
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Invite) {
            throw new UnexpectedTypeException($value, 'Braincrafted\Bundle\UserBundle\Entity\Invite');
        }

        return $value->getCode();
    }

    /**
     * Transforms the given invitation code into the invitation.
     *
     * @param string $value The invitation code
     *
     * @return Invite The invitation
     *
     * @throws UnexpectedTypeException when $value is not a string
     */
    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        return $this->objectManager
            ->getRepository('Braincrafted\Bundle\UserBundle\Entity\Invite')
            ->findOneBy(array(
                'code' => $value
            ));
    }
}
