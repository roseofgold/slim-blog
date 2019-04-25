<?php
/**
 * Blog Entry class to manage blog entries
 */
class BlogEntry  
{
    public function getEntries($db)
    {
        $sql = "SELECT * FROM posts";
        $orderby = ' ORDER BY date DESC';
        try {
            $results = $db->prepare($sql . $orderby);
        } catch (Exception $e) {
            echo "Unable to retrieve entries";
        }
        $results->execute();

        return $entries = $results->fetchAll();
    }
}