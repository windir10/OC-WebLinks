<?php

namespace WebLinks\Controller;

use Silex\Application;

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
}
