<?php

namespace App\Subscriber;

use App\Entity\Comment;
use App\Entity\User;
use App\Event\CommentCreatedEvent;
use App\Event\TrophyUnlokedEvent;
use App\Mailer\AppMailer;
use App\Manager\TrophyManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TrophySubscriber implements EventSubscriberInterface
{
    /**
     * @var AppMailer
     */
    private $mailer;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var TrophyManager
     */
    private $trophyManager;

    public function __construct(AppMailer $mailer, ObjectManager $em, TrophyManager $trophyManager)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->trophyManager = $trophyManager;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            TrophyUnlokedEvent::NAME => 'onTrophyUnlock',
            CommentCreatedEvent::NAME => 'onNewComment'
        ];
    }

    /**
     * @param TrophyUnlokedEvent $event
     * @return int
     * @throws \RuntimeException
     */
    public function onTrophyUnlock(TrophyUnlokedEvent $event): int
    {
        return $this->mailer->trophyUnlocked($event->getTrophy(), $event->getUser());
    }

    /**
     * @param CommentCreatedEvent $event
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function onNewComment(CommentCreatedEvent $event): void
    {
        /** @var User $user */
        $user = $event->getComment()->getUser();
        $comments_count = $this->em->getRepository(Comment::class)->countForUser($user->getId());
        $this->trophyManager->checkAndUnlock($user, 'comment', $comments_count);
    }
}