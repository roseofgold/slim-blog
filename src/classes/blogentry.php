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

    public function editEntry($db,$id,$title,$body)
    {        
        $sql = 'UPDATE posts SET title = ?, body = ? WHERE id = ?';

        try{
          $results = $db->prepare($sql);
          $results->bindValue(1,$title,PDO::PARAM_STR);
          $results->bindValue(2,$body,PDO::PARAM_STR);
          $results->bindValue(3,$id,PDO::PARAM_INT);
        } catch (Exception $e){
          echo "Unable to retrieve results: " . $e->getMessage();
          exit;
        }
        $results->execute();
      
        return $results;
      
    }

    public function addEntry($db,$title,$body)
    {
        $sql = 'INSERT INTO posts (title,body,date) VALUES (?,?,?)';

        try {
            $results = $db->prepare($sql);
            $results->bindValue(1,$title,PDO::PARAM_STR);
            $results->bindValue(2,$body,PDO::PARAM_STR);
            $results->bindValue(3,date('Y-m-d H:i'),PDO::PARAM_STR);
        } catch (Exception $e) {
            echo "Unable to add entry: " . $e->getMessage();
            exit;
        }

        $results->execute();

        return $results;
    }

    public function getEntryID($db,$title)
    {
        $sql = "SELECT id FROM posts WHERE title=? ORDER BY date LIMIT 1";

        try {
            $results = $db->prepare($sql);
            $results->bindParam(1,$title,PDO::PARAM_STR);
        } catch (Exception $e) {
            echo "Unable to retrieve entry's id: " . $e->getMessage();
            exit;
        }

        $results->execute();

        return $entries = $results->fetch(PDO::FETCH_ASSOC);
    }
}