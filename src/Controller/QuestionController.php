<?php

namespace App\Controller;
use App\Entity\Answer;
use App\Entity\Course;
use App\Entity\Reaction;
use App\Entity\User;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\CourseType;
use App\Form\QuestionType;
use App\Form\ReactionType;
use App\Repository\AnswerRepository;
use App\Repository\CourseRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/course/show/{id}/addQuestion", name="addQuestion")
     */
    public function addQuestion(Request $request, $id, CourseRepository $courseRepository): Response
    {
        $course = $courseRepository->find($id);
        $question = new Question();
        $question->setAuthor($this->getUser());
        $question->setCourse($course);
        $question->setDate(new \DateTime('now'));
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

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
    public function show($id, QuestionRepository $questionRepository, Request $request, AnswerRepository $answerRepository, ReactionRepository $reactionRepository){
        $question = $questionRepository->find($id);
        $answers = $answerRepository->findBy(['question'=> $question]);
        $answersByUser = $answerRepository->findBy(['question'=> $question, 'author'=>$this->getUser()]);

        $answer = new Answer();
        $answer->setAuthor($this->getUser());
        $answer->setQuestion($question);
        $answer->setDate(new \DateTime('now'));
        $formAnswer = $this->createForm(AnswerType::class, $answer, ['attr' => ['id' => 'formAnswer']]);
        $formAnswer->handleRequest($request);

        $reactions = $reactionRepository->findAll();

        if($formAnswer->isSubmitted() && $formAnswer->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($answer);
            $em->flush();

            $this->addFlash('success', 'Answer added!');

            return $this->redirect($this->generateUrl('showQuestion', [
                'id' => $question->getId()
            ]));
        }



        return $this->render('question/showQuestion.html.twig',[
            'question' => $question,
            'formAnswer' => $formAnswer->createView(),
            'answers' => $answers,
            'answersByUserCount' => count($answersByUser),
            'reactions' => $reactions
        ]);
    }
}
