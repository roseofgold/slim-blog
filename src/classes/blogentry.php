<?php
/**
 * Blog Entry class to manage blog entries
 */
class BlogEntry  
{
    public function getEntries($db)
    {
        $sql = "SELECT * FROM posts";
        try {
            $results = $db->prepare($sql);
        } catch (Exception $e) {
            echo "Unable to retrieve entries";
        }
        $results->execute();

        return $entries = $results->fetchAll();
    }
}