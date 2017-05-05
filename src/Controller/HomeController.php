<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Form\Type\LinkType;

/**
 * Front controller
 *
 * @author Steven DUMONT <windir10 at gmail.com>
 */
class HomeController {
	/**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
		$links = $app['dao.link']->findAll();
		return $app['twig']->render('index.html.twig', array('links' => $links));
    }
	
	/**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
	
	/**
     * Submit link controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function submitLinkAction(Request $request, Application $app) {
        $linkFormView = null;
		
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add link
			$link = new Link();
			
			$user = $app['user'];
			$link->setUser($user);
			
			$linkForm = $app['form.factory']->create(LinkType::class, $link);
			$linkForm->handleRequest($request);
			if($linkForm->isSubmitted() && $linkForm->isValid()) {
				$app['dao.link']->save($link);
				$app['session']->getFlashBag()->add('success', 'Your link was successfully added.');
			}
			$linkFormView = $linkForm->createView();
        }
        
        return $app['twig']->render('link_form.html.twig', array(
			'linkForm' => $linkFormView,
			'title' => 'New link',
			'frontMenu' => true, // for setting active style for item menu "Submit link"
		));
    }
}
