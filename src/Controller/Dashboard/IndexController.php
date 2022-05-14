<?php

namespace App\Controller\Dashboard;

use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{
    /**
     * @Route("/dashboard", name="dashboard")
    */

    public function index()
    {

        //rolses ROLE_ADMIN, IS_AUTHENTICATED_FULLY
       // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //$this->isGranted('IS_AUTHENTICATED_FULLY');
        //dd($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'));
        //dd($this->isGranted('IS_AUTHENTICATED_FULLY'));

//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            throw $this->createAccessDeniedException();
//        }

        return $this->render('dashboard/index/index.html.twig',[
            'user'=>$this->user
        ]);

    }

}
