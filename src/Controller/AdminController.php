<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Domain\User;
use WebLinks\Form\Type\LinkType;
use WebLinks\Form\Type\UserType;

/**
 * Back-office controller
 *
 * @author Steven DUMONT <windir10 at gmail.com>
 */
class AdminController {
	
	/**
	 * Admin home page
	 * 
	 * @param Application $app
	 */
	public function indexAction(Application $app) {
        $links = $app['dao.link']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'links' => $links,
            'users' => $users));
    }
	
	/**
	 * Add link form
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function addLinkAction(Request $request, Application $app) {
        $link = new Link();
		
		$user = $app['user'];
		$link->setUser($user);
		
        $linkForm = $app['form.factory']->create(LinkType::class, $link);
        $linkForm->handleRequest($request);
        if ($linkForm->isSubmitted() && $linkForm->isValid()) {
            $app['dao.link']->save($link);
            $app['session']->getFlashBag()->add('success', 'The link was successfully created.');
        }
		$linkFormView = $linkForm->createView();
		
		return $app['twig']->render('link_form.html.twig', array(
			'linkForm' => $linkFormView,
			'title' => 'New link',
			'adminMenu' => true, // for setting active style for item menu "Administration"
		));
    }
	
	/**
	 * Update link form
	 * 
	 * @param integer $id The link'is id
	 * @param Request $request
	 * @param Application $app
	 */
	public function editLinkAction($id, Request $request, Application $app) {
        $link = $app['dao.link']->find($id);
        $linkForm = $app['form.factory']->create(LinkType::class, $link);
        $linkForm->handleRequest($request);
        if ($linkForm->isSubmitted() && $linkForm->isValid()) {
            $app['dao.link']->save($link);
            $app['session']->getFlashBag()->add('success', 'The link was successfully updated.');
        }
		$linkFormView = $linkForm->createView();
		
		return $app['twig']->render('link_form.html.twig', array(
			'linkForm' => $linkFormView,
			'title' => 'Update link',
			'adminMenu' => true, // for setting active style for item menu "Administration"
		));
    }
	
	/**
	 * Deleting a link
	 * 
	 * @param integer $id The link'is id
	 * @param Application $app
	 */
	public function deleteLinkAction($id, Application $app) {
        // Delete the link
        $app['dao.link']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The link was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
	
	/**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));
    }
	
	/**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));
    }
	
	/**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated links
        $app['dao.link']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}
