<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // route to main page
    $app->get(
        '/', 
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            // connect to database
            $db = $container->get('db');

            // display posts
            $args['posts'] = $this->entry->getEntries($db);

            // Render index view
            return $container->get('renderer')->render($response, 'index.phtml', $args);
        }
    );

    // route to blog entry
    $app->get(
        '/blog/{id}',
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");
            
            // Get ID to aid is display of entry
            $id = $request->getAttribute('id');

            // connect to database
            $db = $container->get('db');

            // select specific post to display
            $sql = "SELECT * FROM posts";
            $sql .= " WHERE id = ?";
            try {
                $results = $db->prepare($sql);
                $results->bindParam(1,$id);
            } catch (Exception $e) {
                echo "Unable to retrieve results: " . $e->getMessage();
                exit;
            }
            $results->execute();
            $args['posts'] = $results->fetch(PDO::FETCH_ASSOC);

            // Render index view
            return $container->get('renderer')->render($response, 'detail.phtml', $args);
        }
    );

    // route to edit blog entry
    $app->get(
        '/edit/{id}',
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            // Get ID to aid is display of entry
            $id = $request->getAttribute('id');
            
            // connect to database
            $db = $container->get('db');

            // select specific post to display
            $sql = "SELECT * FROM posts ";
            $sql .= "WHERE id = ?";
            try {
                $results = $db->prepare($sql);
                $results->bindParam(1,$id);
            } catch (Exception $e) {
                echo "Unable to retrieve results: " . $e->getMessage();
                exit;
            }
            $results->execute();
            $args['posts'] = $results->fetch(PDO::FETCH_ASSOC);

            // select comments on specific post
            $sql = "SELECT * FROM comments AS c JOIN posts_comments AS pc ON c.id = pc.comment_id JOIN posts AS p ON pc.post_id = p.id WHERE p.id = ?";
            try {
                $results = $db->prepare($sql);
                $results->bindValue(1,$id);
            } catch (Exception $e) {
                echo "Unable to retrieve results: " . $e->getMessage();
                exit;
            }
            $results->execute();
            $args['comments'] = $results->fetchAll(PDO::FETCH_ASSOC);

            // Render index view
            return $container->get('renderer')->render($response, 'edit.phtml', $args);
        }
    );

    // route to new blog entry
    $app->get(
        '/new',
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            // Render index view
            return $container->get('renderer')->render($response, 'new.phtml', $args);
        }
    );
};
