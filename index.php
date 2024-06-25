<?php
// Simple Router
// This router needs to be improved ...

// Include the helper file for handling requests
require_once __DIR__ . '/assets/helpers/request.php';
require_once __DIR__ . '/assets/helpers/core.php';
// Include the database connection
require_once __DIR__ . '/assets/config/connexionDB.php';

// Switch statement to handle different routes based on the path from the URL
switch ($url['path']) {
        // Case: Root path '/'
    case '/':
        // Check if the HTTP method is GET
        if ($method == 'GET') {
            // Include the 'views/index.php' file for the root path
            require __DIR__ . '/assets/controllers/HomeController.php';
            index();
        } else error(405);
        break;

        // Case: Handle '/pokemon' path
    case '/pokemon':
        // Check if the HTTP method is GET
        if ($method == 'GET') {
            // Check if the 'query' part of the URL is set, if not, call 'error()' function
            if (!isset($url['query'])) error();
            // Parse the query string of the URL and store the result in the 'result' array
            parse_str($url['query'], $result);
            // Sanitize the 'name' parameter using htmlspecialchars to prevent XSS attacks
            if (isset($result['name'])) $result['name'] = htmlspecialchars($result['name']);

            // Check if the 'name' parameter is set and not empty, if not, call 'error()' function
            if (!isset($result["name"]) || empty($result["name"])) error();

            // Include the 'views/pages/show.php' file to handle the display logic
            require __DIR__ . '/assets/controllers/HomeController.php';
            show($result['name']);
            // Terminate the script to ensure no further code is executed
            die();
        } else error(405);
        break;

        // Default case: Handle all other paths by calling 'error()' function
    default:
        error();
        break;
}
