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

            // display posts
            $args['posts'] = $this->entry->getEntries($db,$id);

            // select comments on specific post
            $args['comments'] = $this->comment->displayComments($db,$id);

            // Render index view
            return $container->get('renderer')->render($response, 'detail.phtml', $args);
        }
    );

    // route to edit blog entry
    $app->map(
        ['GET','POST'],
        '/edit/{id}',
        function (Request $request, Response $response, array $args) use ($container) {
            if ($request->getMethod() == 'POST') {
            }

            // prevent crossite issues
            $nameKey = $this->csrf->getTokenNameKey();
            $valueKey =$this->csrf-> getTokenValueKey();
            $args['csrf'] = [
                $nameKey => $request->getAttribute($nameKey),
                $valueKey => $request->getAttribute($valueKey)
            ];
            
            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/' route");

            // Get ID to aid is display of entry
            $id = $request->getAttribute('id');
            
            // connect to database
            $db = $container->get('db');

            // display posts
            $args['posts'] = $this->entry->getEntries($db,$id);

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
