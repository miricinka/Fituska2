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
}
