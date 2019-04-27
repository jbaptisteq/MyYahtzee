<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditEmailFormType;

class AccountController extends AbstractController
{
    /**
    * @Route("/account", name="app_account")
    */
    public function account(): Response
    {

        return $this->render('pages/account.html.twig');
    }

    /**
    * @Route("/account/editEmail", name="app_editEmail")
    */
    public function editEmail(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditEmailFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setEmail($form->get('email')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_account');
        }

        return $this->render('pages/editEmail.html.twig', [
            'editEmailForm' => $form->createView(),
        ]);
    }

    public function changePassword()
    {

    }

}
