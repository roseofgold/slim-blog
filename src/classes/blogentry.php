<?php
/**
 * Blog Entry class to manage blog entries
 */
class BlogEntry  
{
    public function getEntries($db,$id=NULL)
    {
        $sql = "SELECT * FROM posts";
        if ($id!=NULL) {
            $where = " WHERE id=" . $id;
        } else {
            $where = "";
        }
        $orderby = ' ORDER BY date DESC';
        try {
            $results = $db->prepare($sql . $where . $orderby);
        } catch (Exception $e) {
            echo "Unable to retrieve entries";
        }
        $results->execute();

        return $entries = $results->fetchAll();
    }
}