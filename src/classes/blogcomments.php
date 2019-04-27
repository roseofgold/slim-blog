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
            $results->bindValue(1,$id,PDO::PARAM_STR);
        } catch (Exception $e) {
            echo "Unable to retrieve results: " . $e->getMessage();
            exit;
        }
        $results->execute();
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enterComment($db,$name,$commentBody,$id)
    {
        // enter comment into comments database
        $sql = "INSERT INTO comments (name,body,date_time) VALUES (?,?,?)";

        try {
            $results = $db->prepare($sql);
            $results->bindValue(1,$name,PDO::PARAM_STR);
            $results->bindValue(2,$commentBody,PDO::PARAM_STR);
            $results->bindValue(3,date('Y-m-d H:i'),PDO::PARAM_STR);
        } catch (Exception $e) {
            echo "Unable to enter comment into database: " . $e->getMessage();
            exit;
        }
        $results->execute();

        // retrieve comment's id
        $sql = "SELECT id FROM comments WHERE name=? AND date_time = ?";

        try {
            $results = $db->prepare($sql);
            $results->bindParam(1,$name,PDO::PARAM_STR);
            $results->bindParam(2,$date_time,PDO::PARAM_STR);
        } catch (Exception $e) {
            echo "Unable to retrieve comment's id: " . $e->getMessage();
            exit;
        }

        $results->execute();

        $comment_id = $results->fetch(PDO::FETCH_ASSOC);


        // connect comment to blog
        $sql = "INSERT INTO posts_comments (post_id,comment_id VALUES (?,?)";

        try {
            $results = $db->prepare($sql);
            $results->bindValue(1,$id,PDO::PARAM_STR);
            $results->bindValue(2,$comment_id,PDO::PARAM_STR);
        } catch (Exception $e) {
            echo "Unable to connect comment to post: " . $e->getMessage();
            exit;
        }
        $results->execute();
    }
}
