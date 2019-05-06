<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditEmailFormType;
use App\Form\ChangePasswordFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
    * @Route("/account/changePassword", name="app_changePassword")
    */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_account');
        }

        return $this->render('pages/changePassword.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }

    public function forgetPassword()
    {

    }

    public function resetPassword()
    {

    }

}
