<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserBundle\Form\Type\CreateUserType;
use Bc\Bundle\UserBundle\Form\Type\UpdateUserType;
use Bc\Bundle\UserBundle\Entity\User;

/**
 * UserAdminController
 *
 * @category    Controller
 * @package     BcUserBundle
 * @subpackage  Controller
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class UserAdminController extends Controller
{
    /**
     * List action.
     *
     * @return string The response
     */
    public function listAction()
    {
        $userManager = $this->getUserManager();

        return $this->render('BcUserBundle:UserAdmin:list.html.twig', array(
            'users' => $userManager->findUsers()
        ));
    }

    /**
     * The create action.
     *
     * @param Request $request The request
     *
     * @return string The response
     */
    public function createAction(Request $request)
    {
        $userManager = $this->getUserManager();
        $form = $this->createForm(new CreateUserType(), $userManager->createUser());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $user = $form->getData();
                $this->getUserManager()->updateUser($user);
                $this->flash('success', sprintf('The user %s has been created.', $user->getUsername()));
                return $this->redirect($this->generateUrl('bc_user_admin_list'));
            }
        }

        return $this->render('BcUserBundle:UserAdmin:create.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * The update action.
     *
     * @param integer $userId  The user ID
     * @param Request $request The request object
     *
     * @return string          The response
     */
    public function updateAction($userId, Request $request)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->findUserBy(array('id' => $userId));

        if (!$user) {
            $this->flash('error', sprintf('There is no user with the ID %d', $userId));
            return $this->redirect($this->generateUrl('bc_user_admin_list'));
        }

        $form = $this->createForm(new UpdateUserType(), $user);
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $user = $form->getData();
                $userManager->updateUser($user);

                $this->flash('success', sprintf('The user %s has been updated.', $user->getUsername()));
                return $this->redirect($this->generateUrl('bc_user_admin_list'));
            }
        }

        $user->getCreatedAt()->setTimezone(new \DateTimeZone($user->getTimezone()));
        $user->getUpdatedAt()->setTimezone(new \DateTimeZone($user->getTimezone()));

        return $this->render('BcUserBundle:UserAdmin:update.html.twig', array(
            'user'  => $user,
            'form'  => $form->createView()
        ));
    }

    /**
     * The delete action.
     *
     * @param integer $userId The user ID
     *
     * @return string The response
     */
    public function deleteAction($userId)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->findUserBy(array('id' => $userId));
        if ($user) {
            $userManager->deleteUser($user);
            $this->flash('success', sprintf('The user %s has been deleted.', $user->getUsername()));
        } else {
            $this->flash('error', sprintf('There is no user with the ID %d', $userId));
        }

        return $this->redirect($this->generateUrl('bc_user_admin_list'));
    }

    /**
     * Sets a flash message.
     *
     * @param  string $type    The type of message (error|info|success|warning)
     * @param  string $message The message
     * @return void
     */
    protected function flash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type, $message);
    }

    /**
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('bc_user.user_manager');
    }
}