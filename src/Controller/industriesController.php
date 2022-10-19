<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\DataObject\Industries;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pimcore\Targeting\VisitorInfoStorageInterface;

class industriesController extends FrontendController
{

    /**
     * @var VisitorInfoStorageInterface
     */
    private $visitorInfoStorage;

    public function __construct(VisitorInfoStorageInterface $visitorInfoStorage)
    {
        $this->visitorInfoStorage = $visitorInfoStorage;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function industriesListingAction(Request $request): Response
    {
        $data = array();
      
        $industries = new Industries\Listing();
        $industries->setLimit(3);
        $industries->load();
        foreach ($industries as $key => $industry) {
            $data[$key]['id'] = $industry->getId();
            $data[$key]['name'] = $industry->getName();
            $data[$key]['url'] = $industry->getUrl();
        }
        $visitorInfo = $this->getVisitorInfo();
        //dd($visitorInfo);
        
        if($visitorInfo){
        $AssignGroups = $visitorInfo->getAssignedTargetGroups();
        }else{
            $AssignGroups = '';
        }
        
     //  dd($AssignGroups[0]->getName());
      

        return $this->render('Industries/industries_listimg.html.twig', [
            'data' =>$data,
            'targetName'=>$AssignGroups != null ? $AssignGroups[0]->getName() : ''
        ]);
    }

    /**
     *  @Route("/industries/{url}", name="industries-detail")
     */
    public function industryDetailAction(Request $request): Response
    {
        $url =   htmlspecialchars(trim(strip_tags($request->get('url'))));
       

        $industry = new Industries\Listing();
        $industry->setCondition("url =?" ,[$url]);
        $industry->load();
        if(count($industry) > 0){

        foreach ($industry as $key => $Tndustry) {
            break;
        }
        }else {
            throw new NotFoundHttpException('Product not found.');
        }

        $visitorInfo = $this->getVisitorInfo();
        //$groups = $id->getAssignedTargetGroups();
        $AssignGroups = $visitorInfo->getAssignedTargetGroups();
        $MatchingGroups = $visitorInfo->getMatchingTargetingRules();
        $TargetGroupAssignments = $visitorInfo->getTargetGroupAssignments();
       // $sortedTargetGroupAssignments =  $visitorInfo->getSortedTargetGroupAssignments();
       // $TargetGroups = $visitorInfo->getTargetGroups();
        //dd($visitorInfo);
        // dd($TargetGroupAssignments[1]->getCount());     
        
        return $this->render('Industries/industry_detail.html.twig',
            [
                'industry'=>$Tndustry
            ]

        );
    }



    public function getVisitorInfo()
    {
        // always check if there is a visitor info before trying to fetch it
        if (!$this->visitorInfoStorage->hasVisitorInfo()) {
            return null;
        }

        $visitorInfo = $this->visitorInfoStorage->getVisitorInfo();

        //return $visitorInfo->getVisitorId();
        return $visitorInfo;
    }

  
     /**
      * @Route("mail", name="mail")
      */
     public function FunctionName(): Response
     {
        $mail = new \Pimcore\Mail();
        $mail->setIgnoreDebugMode(true);
        $mail->to('mansoor.ali@centric.ae');
        $mail->bcc("mansoorali.babar95@gmail.com");
        // $mail->setDocument('/email/myemaildocument');
        // $mail->setParams($params);
        // $mail->text("This is just plain text");
        $mail->html("<b>some</b> rich text");
        $mail->send();
         return new Response("email send");
     }
    
}
