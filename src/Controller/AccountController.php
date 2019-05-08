<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditEmailFormType;
use App\Form\ChangePasswordFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


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

        /**
        * @Route("/forgetPassword", name="app_forgetPassword")
        */
        public function forgetPassword(Request $request, \Swift_Mailer $mailer)
        {
            if ($request->isMethod('post')) {
                $entityManager = $this->getDoctrine()->getManager();
                $email = $request->request->get('email');
                $user = $entityManager->getRepository(User::class)->FindOneBy(['email' => $email]);
                if ($user !== null) {
                    $user->setToken(md5(random_bytes(10)));
                    $emailsend = $user->getemail();

                    $message = (new \Swift_Message('My Yahtzee Records - Récupération Password'))
                    ->setFrom('noreply@myYahtzeeRecords.fr')
                    ->setTo($user->getEmail())
                    ->setBody($this->renderView('pages/recup.html.twig', array('email' => $user->getEmail(), 'token' => $user->getToken())), 'text/html');
                    $mailer->send($message);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('emailInfo', 'Email Envoyé');
                    return $this->RedirectToRoute('app_forgetPassword');
                } else {
                    $this->addFlash('emailInfo', 'Cet email n\'existe pas');
                    return $this->RedirectToRoute('app_forgetPassword');
                }
            }
            return $this->render('pages/forgetPassword.html.twig');
        }

        /**
        * @Route("/forgetPassword/token={token}", name="app_resetPassword")
        */
        public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, $token)
        {
            if ($request->isMethod('post')) {
                $repository = $this->getDoctrine()->getRepository(User::class);

                if (!$repository->findOneBy(['token' => $token])) {
                    $this->addFlash('infoReset', 'Token utilisé non valide');
                    return $this->redirectToRoute('app_login');
                } else if (!$repository->findOneBy(['email' => $request->request->get('emailCheck')])) {
                    $this->addFlash('infoReset', 'Email utilisé non valide');
                    return $this->redirectToRoute('app_login');
                } else if (empty($request->request->get('newPassword'))) {
                    $this->addFlash('infoReset', 'Veuillez saisir un mot de passe');
                    return $this->redirectToRoute('app_login');
                } else {
                    $entityManager = $this->getDoctrine()->getManager();
                    $user = $entityManager->getRepository(User::class)->FindOneBy(['token' => $token]);
                    $password = $passwordEncoder->encodePassword($user, $request->request->get('newPassword'));
                    $user->setPassword($password);
                    $user->setToken('');
                    $entityManager->flush();
                    $this->addFlash('infoReset', 'Mot de passe changé');
                    return $this->redirectToRoute('app_login');
                }
            }

            return $this->render('pages/reset.html.twig');
        }
    }
