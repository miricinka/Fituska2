<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course", name="course.")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="courses")
     */
    public function index(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll();

        return $this->render('course/index.html.twig', [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/create", name="createCourse")
     */
    public function create(Request $request){
        $course = new Course();
        $course->setAuthor($this->getUser());

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($course);
            $em->flush();

            $this->addFlash('success', 'New course was created!');
            return $this->redirect($this->generateUrl('course.courses'));
        }

        return $this->render('course/create.html.twig',
        [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id, CourseRepository $courseRepository, QuestionRepository $questionRepository){
        $course = $courseRepository->find($id);
        $questions = $questionRepository->findBy(['course'=> $course]);
        if(!$course->getPublished()) {
            if ($this->getUser()) {
                if ($course->getAuthor() !== $this->getUser()) {
                    if ($this->getUser()->getUsername() != "admin" && $this->getUser()->getUsername() != "moderator") {
                        throw $this->createAccessDeniedException();
                    }
                }
            }else {
                throw $this->createAccessDeniedException();
            }
        }
        return $this->render('course/show.html.twig', [
            'course' => $course,
            'questions' => $questions
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove($id, CourseRepository $courseRepository){
        $course = $courseRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($course);
        $em->flush();
        $this->addFlash('success', 'Course was deleted');
        return $this->redirect($this->generateUrl('course.courses'));
    }
    /**
     * @Route("/publish/{id}", name="publish")
     */
    public function publish($id, CourseRepository $courseRepository){
        $course = $courseRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $course->setPublished(true);
        $em->persist($course);
        $em->flush();
        $this->addFlash('success', 'Course was published');
        return $this->redirect($this->generateUrl('course.courses'));
    }

    /**
     * @Route("/subscribe/{id}", name="subscribe")
     */
    public function subscribeToCourse($id, CourseRepository $courseRepository){
        $course = $courseRepository->find($id);
        $course->addStudent($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->flush();

        return $this->redirect($this->generateUrl('course.courses'));
    }

}
