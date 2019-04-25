<?php

/**
 * Blog Comments class
 */
class BlogComments
{
    public function displayComments($db,$id)
    {
        $sql = "SELECT c.* FROM comments AS c"
            . " JOIN posts_comments AS pc ON c.id = pc.comment_id"
            . " JOIN posts AS p ON pc.post_id = p.id"
            . " WHERE p.id = ?";
        try {
            $results = $db->prepare($sql);
            $results->bindValue(1,$id);
        } catch (Exception $e) {
            echo "Unable to retrieve results: " . $e->getMessage();
            exit;
        }
        $results->execute();
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}
