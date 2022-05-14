<?php

namespace App\Controller\Dashboard;

use App\Entity\User;

use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\User\UserInterface\UserInterface;


abstract class BaseController extends AbstractController
{
    public $user;
    private $security;

    public function __construct(Security $security){
        $this->security = $security;
        $this->user = $this->security->getUser();
    }
}
