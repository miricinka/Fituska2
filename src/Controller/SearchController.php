<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, UserRepository $userRepository, CourseRepository $courseRepository, QuestionRepository $questionRepository): Response
    {
        $searched = $request->query->get('searched');
        $users = $userRepository->findBySearch($searched);
        $coursesTitle = $courseRepository->findBySearchTitle($searched);
        $coursesID = $courseRepository->findBySearchID($searched);
        $questions = $questionRepository->findBySearch($searched);

        return $this->render('search/search.html.twig', [
            'searched' => $searched,
            'users'=> $users,
            'coursesTitle' => $coursesTitle,
            'coursesID' => $coursesID,
            'questions' => $questions
        ]);
    }
}
