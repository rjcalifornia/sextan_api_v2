<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'sextans_api', '_controller' => 'App\\Controller\\SextansApiController::index'], null, null, null, false, false, null]],
        '/api/v1/show-users' => [[['_route' => 'show_users_api', '_controller' => 'App\\Controller\\SextansApiController::ShowAllUsersAction'], null, null, null, true, false, null]],
        '/api/v1/save-user' => [[['_route' => 'save_user_api', '_controller' => 'App\\Controller\\SextansApiController::saveSingleUserAction'], null, null, null, true, false, null]],
    ],
    [ // $regexpList
    ],
    [ // $dynamicRoutes
    ],
    null, // $checkCondition
];
