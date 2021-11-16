<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reaction;
use App\Form\ReactionType;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{

    /**
     * @Route("/addreaction{id}", name="addReaction")
     */
    public function addReaction($id, AnswerRepository $answerRepository, QuestionRepository $questionRepository, Request $request): Response
    {
        $answer = $answerRepository->find($id);

        $reaction = new Reaction();
        $reaction->setAuthor($this->getUser());
        $reaction->setReactionToAnswer($answer);

        $form = $this->createForm(ReactionType::class, $reaction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $reaction->setDate(new \DateTime('now'));

            $em->persist($reaction);
            $em->flush();

            $this->addFlash('success', 'Reaction was added!');
            return $this->redirect($this->generateUrl('showQuestion', [
                'id' => $answer->getQuestion()->getId()
            ]));
        }


        return $this->render('answer/addReaction.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/question/answer/like/{id}", name="liked")
     */
    public function like($id, AnswerRepository $answerRepository){
        $answer = $answerRepository->find($id);
        $question = $answer->getQuestion();

        $em = $this->getDoctrine()->getManager();

        if(in_array($this->getUser(), $answer->getLikedByUsers()->toArray())){
            $answer->removeLikedByUser($this->getUser());
            $answer->setLikes($answer->getLikes()-1);
            $em->persist($answer);
            $em->flush();
        }else{

            $allAnswers = $answerRepository->findBy(['question'=>$question]);
            $count = 0;
            foreach ($allAnswers as $oneAnswer){
                if(in_array($this->getUser(), $oneAnswer->getLikedByUsers()->toArray())){
                    $count++;
                }
            }

            if($count == 3) {
                $this->addFlash('warning', 'You have already liked 3 answers');
            }else{
                $answer->addLikedByUser($this->getUser());
                $answer->setLikes($answer->getLikes()+1);
                $em->persist($answer);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('showQuestion', [
            'id' => $question->getId()
        ]));
    }

    /**
     * @Route("/question/answer/correct/{id}", name="markAsCorrect")
     */
    public function markAsCorrect($id, AnswerRepository $answerRepository){
        $answer = $answerRepository->find($id);
        $question = $answer->getQuestion();
        $em = $this->getDoctrine()->getManager();

        $answer->setIsCorrect(true);

        $author = $answer->getAuthor();
        $author->setScore($author->getScore() + $answer->getLikes());
        $em->persist($answer);
        $em->persist($author);
        $em->flush();

        return $this->redirect($this->generateUrl('showQuestion', [
            'id' => $question->getId()
        ]));
    }

}
