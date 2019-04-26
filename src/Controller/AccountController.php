<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function account(): Response
    {

        return $this->render('pages/account.html.twig');
    }

    public function changeEmail()
    {

    }

    public function changePassword()
    {
        
    }

}
