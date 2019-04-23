<?php
/**
 * Blog Entry class to manage blog entries
 */
class BlogEntry  
{
    private $blogTitle,$blogEntry,$postDate,$blogLink;
    
    public function __construct(string $blogTitle = NULL, string $blogEntry = NULL, string $postDate = NULL, string $blogLink = NULL)
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

    public function getEntryShort(){
        $sql = 'SELECT DISTINCT entries.title, entries.date, entries.id FROM entries
            JOIN entries_tags ON entries.id = entries_tags.entry_id
            JOIN tags ON entries_tags.tag_id = tags.tag_id';
        
        $orderby = ' ORDER BY date DESC';
        
        try{
            $results = $db->prepare($sql . $orderby);
        } catch (Exception $e){
            echo "Unable to retrieve results.";
            exit;
        }
        $results->execute();
        
        $entries = $results->fetchAll();
        return $entries;
    }
    
    public function displayShortEntries()
    {
        $entryShort = getEntryShort();

        foreach ($entryShort as $key) {
          $tags = getTags($key['id']);
          echo "<article>";
          echo "<h2><a href=\"/blog/" . $key['id'] . "\">" . $key['title'] . "</a></h2>";
          echo "<time datetime=\"" . $key['date'] . "\">" . date('F j, Y',strtotime($key['date'])) . "</time>";
          echo "<div>";
          if(!empty($tags)){
              foreach($tags as $tag){
                  echo '<a href="index.php?tag=' . $tag['tag_id'] . "\" class=\"journal-tag\">";
                  echo $tag['tag'];
                  echo '</a>';
              }
          }
          echo "</div>";
          echo "</article>";
        }
      
    }
}