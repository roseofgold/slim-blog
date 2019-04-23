<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get(
        '/', 
        function (Request $request, Response $response, array $args) use ($container) {
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            //connect to database
            $db = $container->get('db');
            $sql = "SELECT * FROM posts";
            try{
                $results = $db->query($sql);
            } catch (Exception $e){
                echo "Unable to retrieve results.";
                exit;
            }
            $results->execute();
            $args = $results->fetchAll(PDO::FETCH_ASSOC);

            // Render index view
            return $container->get('renderer')->render($response, 'index.phtml', $args);
        }
    );
    // $app->get(
    //     '/blog/{id}',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         // Sample log message
    //         $container->get('logger')->info("Slim-Skeleton '/' route");

    //         // Render index view
    //         return $container->get('renderer')->render($response, 'detail.phtml', $args);
    //     }
    // );
    // $app->get(
    //     '/new',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         // Sample log message
    //         $container->get('logger')->info("Slim-Skeleton '/' route");

    //         // Render index view
    //         return $container->get('renderer')->render($response, 'new.phtml', $args);
    //     }
    // );
    // $app->get(
    //     '/edit',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         // Sample log message
    //         $container->get('logger')->info("Slim-Skeleton '/' route");

    //         // Render index view
    //         return $container->get('renderer')->render($response, 'edit.phtml', $args);
    //     }
    // );
};
