<?php

namespace App\Controller;
use App\Entity\Answer;
use App\Entity\Course;
use App\Entity\FinalAnswer;
use App\Entity\Reaction;
use App\Entity\User;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\CourseType;
use App\Form\FinalAnswerType;
use App\Form\QuestionType;
use App\Form\ReactionType;
use App\Repository\AnswerRepository;
use App\Repository\CourseRepository;
use App\Repository\FinalAnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class QuestionController extends AbstractController
{
    /**
     * @Route("/course/show/{id}/addQuestion", name="addQuestion")
     */
    public function addQuestion(Request $request, $id, CourseRepository $courseRepository, SluggerInterface $slugger): Response
    {
        $course = $courseRepository->find($id);
        if(!in_array($this->getUser(), $course->getStudents()->toArray()) and $this->getUser() != $course->getAuthor()){
            $this->addFlash('danger', 'You must be enrolled in order to add question');
            return $this->redirect($this->generateUrl('course.courses'));
        }
        $question = new Question();
        $question->setAuthor($this->getUser());
        $question->setCourse($course);
        $question->setDate(new \DateTime('now'));
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $imageFile = $form->get('image')->getData();
            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $question->setImage($newFilename);
            }

            $em->persist($question);
            $em->flush();

            $this->addFlash('success', 'New question was created!');
            return $this->redirect($this->generateUrl('showQuestion', [
                'id' => $question->getId()
            ]));
        }

        return $this->render('question/index.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("question/show/{id}", name="showQuestion")
     */
    public function show($id, QuestionRepository $questionRepository, Request $request, AnswerRepository $answerRepository, ReactionRepository $reactionRepository, FinalAnswerRepository $finalAnswerRepository, SluggerInterface $slugger){
        $question = $questionRepository->find($id);
        $answers = $answerRepository->findBy(['question'=> $question]);
        $answersByUser = $answerRepository->findBy(['question'=> $question, 'author'=>$this->getUser()]);
        $finalAnswer = $finalAnswerRepository->findOneBy(['question'=> $question]);

        $answer = new Answer();
        $answer->setAuthor($this->getUser());
        $answer->setQuestion($question);
        $answer->setDate(new \DateTime('now'));
        $formAnswer = $this->createForm(AnswerType::class, $answer, ['attr' => ['id' => 'formAnswer']]);
        $formAnswer->handleRequest($request);

        $newFinalAnswer = new FinalAnswer();
        $newFinalAnswer->setQuestion($question);
        $newFinalAnswer->setDate(new \DateTime('now'));
        $formFinalAnswer = $this->createForm(FinalAnswerType::class, $newFinalAnswer, ['attr' => ['id' => 'formFinalAnswer']]);
        $formFinalAnswer->handleRequest($request);

        $reactions = $reactionRepository->findAll();

        if($formAnswer->isSubmitted() && $formAnswer->isValid()){
            $em = $this->getDoctrine()->getManager();

            $imageFile = $formAnswer->get('image')->getData();
            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $answer->setImage($newFilename);
            }

            $em->persist($answer);
            $em->flush();

            $this->addFlash('success', 'Answer added!');

            return $this->redirect($this->generateUrl('showQuestion', [
                'id' => $question->getId()
            ]));
        }

        if($formFinalAnswer->isSubmitted() && $formFinalAnswer->isValid()){
            $em = $this->getDoctrine()->getManager();
            $question->setClosed(true);
            $em->persist($question);

            $imageFile = $formFinalAnswer->get('image')->getData();

            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $newFinalAnswer->setImage($newFilename);
            }

            $em->persist($newFinalAnswer);
            $em->flush();

            $this->addFlash('success', 'Final answer added! DO NOT FORGET to mark correct answers.');
            return $this->redirect($this->generateUrl('showQuestion', [
                'id' => $question->getId()
            ]));
        }


        return $this->render('question/showQuestion.html.twig',[
            'question' => $question,
            'formAnswer' => $formAnswer->createView(),
            'formFinalAnswer' => $formFinalAnswer->createView(),
            'answers' => $answers,
            'answersByUserCount' => count($answersByUser),
            'reactions' => $reactions,
            'finalAnswer' => $finalAnswer
        ]);
    }
}
