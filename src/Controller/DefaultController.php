<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FrontendController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
        return $this->render('default/default.html.twig');
    }
      /**
     * @param Request $request
     * @return Response
     */
    public function testAction(): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('snippets/standard-teaser.html.twig');
    }
}
