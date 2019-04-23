<?php

/**
 * undocumented class
 */
class BlogComments
{
    private $commentMessage,$commentDate,$commentUser;

    public function __construct(string $commentMessage = NULL, string $commentDate = NULL, string $commentUser = NULL)
    {
        // add message to class if present
        // otherwise set to empty string
        if (!empty($commentMessage)) {
            $this->commentMessage = $commentMessage;
        } else {
            $this->commentMessage = '';
        }
        
        // add date to class if present
        // otherwise set to today's date
        if (!empty($commentDate)) {
            $this->commentDate = $commentDate;
        } else {
            $this->commentDate = date('Y-m-d');
        }
        
        // add commenter to class if present
        // otherwise set to string 'anonymous'
        if (!empty($commentUser)) {
            $this->commentUser = $commentUser;
        } else {
            $this->commentUser = 'anonymous';
        }
    }

    public function getMessage()
    {
        return $this->commentMessage;
    }

    public function setMessage($commentMessage)
    {
        $this->commentMessage = $commentMessage;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }

    public function getCommentUser()
    {
        return $this->commentUser;
    }

    public function setCommentUser($commentUser)
    {
        $this->commentUser = $commentUser;
    }
}
