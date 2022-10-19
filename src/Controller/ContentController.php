<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\Document;
use Pimcore\Targeting\Document\DocumentTargetingConfigurator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class ContentController extends FrontendController
{
    /**
     *  @Route("/path",name="name")
     */
   
    public function pageAction(DocumentTargetingConfigurator $targetingConfigurator)
    {
        // load any document
        $document = Document::getByPath('/industries');
        dd($document);
        // configure personalized content based on resolved target groups
        // and available personalized content on the document
        $targetingConfigurator->configureTargetGroup($document);
        
        //...
    }
    
    /**
     * @Route("/target/{data}", name="addTargetGroups")
     */
    public function targetGroup(Request $request)
    {
       // dd($request->get('data'));
       // return $this->render('$0.html.twig', []);
       //return $this->redirect('/industries' ,301);
      return $this->redirect($_SERVER['HTTP_REFERER']);
       //return $this->redirectToRoute('assignTargetGroup', ['no-referer-redirect' => true]);
       
    }

}