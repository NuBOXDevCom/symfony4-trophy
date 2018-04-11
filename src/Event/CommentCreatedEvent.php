<?php

namespace App\Event;

use App\Entity\Comment;
use Symfony\Component\EventDispatcher\Event;

class CommentCreatedEvent extends Event
{
    public const NAME = 'comment.created';

    /**
     * @var Comment
     */
    private $comment;

    /**
     * CommentCreatedEvent constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }
}