<?php

namespace App\Mailer;


use App\Entity\Trophy;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;


class AppMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var EngineInterface
     */
    private $template;

    /**
     * AppMailer constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $template
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }

    /**
     * @param Trophy $trophy
     * @param User $user
     * @return int
     * @throws \RuntimeException
     */
    public function trophyUnlocked(Trophy $trophy, User $user): int
    {
        $message = (new \Swift_Message("You unlocked the {$trophy->getName()} trophy !"))
            ->setTo($user->getEmail())
            ->setFrom('noreply@doe.com')
            ->setBody($this->template->render('emails/new_trophy.text.twig', [
                'trophy' => $trophy,
                'user' => $user
            ]));
        return $this->mailer->send($message);
    }
}