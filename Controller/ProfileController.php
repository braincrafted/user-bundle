<?php

namespace Braincrafted\Bundle\UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ProfileController as BaseProfileController;
use FOS\UserBundle\Model\UserInterface;

class ProfileController extends BaseProfileController
{
    /**
     * Delete action.
     *
     */
    public function deleteAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $this->container->get('braincrafted_user.user_manager')->deleteUser($user);

        return new RedirectResponse(
            $this->container->get('router')->generate(
                'braincrafted_user_delete_success',
                array('username' => $user->getUsername())
            )
        );
    }

    public function deleteSuccessAction($username)
    {
        return $this->container->get('templating')->renderResponse(
            'BraincraftedUserBundle:Profile:deleteSuccess.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('username' => $username)
        );
    }
}
