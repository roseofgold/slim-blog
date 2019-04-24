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
            // Select all posts for display
            $sql = "SELECT * FROM posts";
            try{
                $results = $db->query($sql);
            } catch (Exception $e){
                echo "Unable to retrieve results.";
                exit;
            }
            $results->execute();
            $args['posts'] = $results->fetchAll(PDO::FETCH_ASSOC);
            
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

            // Render index view
            return $container->get('renderer')->render($response, 'detail.phtml', $args);
        }
    );
    $app->get(
        '/new',
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            // Render index view
            return $container->get('renderer')->render($response, 'new.phtml', $args);
        }
    );
    $app->get(
        '/edit/{id}',
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            // Get ID to aid is display of entry
            $id = $request->getAttribute('id');

            // Render index view
            return $container->get('renderer')->render($response, 'edit.phtml', $args);
        }
    );
};
