<?php
/**
 * Blog Entry class to manage blog entries
 */
class BlogEntry  
{
    private $blogTitle,$blogEntry,$postDate,$blogLink;
    
    public function __construct(string $blogTitle = NULL, string $blogEntry = NULL, string $postDate, string $blogLink)
    {
        if ($blogTitle == NULL || !empty($blogTitle)) {
            $this->blogTitle = '';
        } else {
            $this->blogTitle = $blogTitle;
        }

        if ($blogEntry == NULL || !empty($blogEntry)) {
            $this->blogEntry = '';
        } else {
            $this->blogEntry = $blogEntry;
        }

        if ($postDate == NULL || !empty($postDate)) {
            $this->postDate = '';
        } else {
            $this->postDate = $postDate;
        }

        if ($blogLink == NULL || !empty($blogLink)) {
            $this->blogLink = '';
        } else {
            $this->blogLink = $blogLink;
        }
    }
    
    public function getTitle()
    {
        return $this->blogTitle;
    }

    public function setTitle($blogTitle)
    {
        $this->blogTitle = $blogTitle;
    }

    public function getEntry()
    {
        return $this->blogEntry;
    }
    
    public function setEntry($blogEntry)
    {
        $this->blogEntry = $blogEntry;
    }

    public function getDate()
    {
        return $this->postDate;
    }

    public function setDate($postDate)
    {
        $this->postDate = $postDate;
    }

    public function getLink()
    {
        return $this->blogLink;
    }

    public function setLink($blogLink)
    {
        $this->blogLink = $blogLink;
    }
}
