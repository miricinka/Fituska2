<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/show/{id}", name="users.show")
     */
    public function show($id, UserRepository $userRepository){
        $user = $userRepository->find($id);
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/delete/{id}", name="users.delete")
     */
    public function delete($id, UserRepository $userRepository){
        $user = $userRepository->find($id);
        //delete TODO
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'User was deleted');
        return $this->redirect($this->generateUrl('users'));
    }
}
