<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Event\CommentCreatedEvent;
use App\Form\AppCommentType;
use App\Manager\TrophyManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{
    /**
     * @Route("/create", name="comment_create")
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \LogicException
     */
    public function newAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        /** @var User $user */
        $user = $this->getUser();
        $comment->setUser($user);
        $form = $this->createForm(AppCommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $this->getDoctrine()->getConnection()->beginTransaction();
            $em->flush();
            $this->get('event_dispatcher')->dispatch(CommentCreatedEvent::NAME, new CommentCreatedEvent($comment));
            $this->getDoctrine()->getConnection()->commit();
        }
        $comments = $em->getRepository(Comment::class)->findAll();
        $trophies = $this->get(TrophyManager::class)->getTrophiesFor($user);
        return $this->render('comment/new.html.twig', [
            'comments' => $comments,
            'trophies' => $trophies,
            'form' => $form->createView()
        ]);
    }
}