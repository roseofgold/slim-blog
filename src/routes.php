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
            // $container->get('logger')->info("Slim-Skeleton '/' route");

            // connect to database
            $db = $container->get('db');

            // display posts
            $args['posts'] = $this->entry->getEntries($db);

            // Render index view
            return $container->get('renderer')->render($response, 'index.phtml', $args);
        }
    );

    // route to blog entry
    $app->map(
        ['GET','POST'],
        '/blog/{id}',
        function (Request $request, Response $response, array $args) use ($container) {
            // Get ID to aid is display of entry
            $id = $request->getAttribute('id');

            // Sample log message
            // $container->get('logger')->info("Slim-Skeleton '/blog/$id' route");
            
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
            // connect to database
            $db = $container->get('db');

            // Get ID to aid is display of entry
            $id = $request->getAttribute('id');
            
            if ($request->getMethod() == 'POST') {
                $args = array_merge($args, $request->getParsedBody());
                
                // use posted data to update an entry
                $edit = $this->entry->editEntry($db,$args['id'],$args['title'],$args['body']);

                // log the edited post's title
                $container->get('logger')->notice('Edited Blog: '.$args['title']);

                return $response->withStatus(302)->withHeader('Location', '/blog/' . $args['id']);
            }
            
            // prevent crossite issues
            $nameKey = $this->csrf->getTokenNameKey();
            $valueKey =$this->csrf-> getTokenValueKey();
            $args['csrf'] = [
                $nameKey => $request->getAttribute($nameKey),
                $valueKey => $request->getAttribute($valueKey)
            ];
            
            // display posts
            $args['posts'] = $this->entry->getEntries($db,$id);

            // Sample log message
            // $container->get('logger')->info("Slim-Skeleton '/edit' route");

            // Render index view
            return $container->get('renderer')->render($response, 'edit.phtml', $args);
        }
    );

    // route to new blog entry
    $app->map(
        ['GET','POST'],
        '/new',
        function (Request $request, Response $response, array $args) use ($container) {
            // connect to database
            $db = $container->get('db');

            if ($request->getMethod() == 'POST') {
                $args = array_merge($args, $request->getParsedBody());
                
                // use posted data to add an entry
                $addEntry = $this->entry->addEntry($db,$args['title'],$args['body']);

                // log the added post's title
                $container->get('logger')->notice('Added New Blog: '.$args['title']);

                //get the id of the recently added post
                $entryID = $this->entry->getEntryID($db,$args['title']);

                return $response->withStatus(302)->withHeader('Location', '/blog/' . $entryID['id']);
            }            

            // prevent crossite issues
            $nameKey = $this->csrf->getTokenNameKey();
            $valueKey =$this->csrf-> getTokenValueKey();
            $args['csrf'] = [
                $nameKey => $request->getAttribute($nameKey),
                $valueKey => $request->getAttribute($valueKey)
            ];

            // Sample log message
            $container->get('logger')->info("Slim-Skeleton '/new' route");

            // Render index view
            return $container->get('renderer')->render($response, 'new.phtml', $args);
        }
    );
};
