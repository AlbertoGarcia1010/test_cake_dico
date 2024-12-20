<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
  * So you can use  `$this` to reference the application class instance
  * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);
    

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Home', 'action' => 'home']);
        $builder->connect('/home/money', ['controller' => 'Home', 'action' => 'banxico']);

        $builder->connect('/customer', ['controller' => 'Customer', 'action' => 'index']);
        $builder->connect('/customer/getall', ['controller' => 'Customer', 'action' => 'getAll']);
        $builder->connect('/customer/get', ['controller' => 'Customer', 'action' => 'getById']);
        $builder->connect('/customer/create', ['controller' => 'Customer', 'action' => 'create']);

        $builder->connect('/employee', ['controller' => 'Employee', 'action' => 'index']);
        $builder->connect('/employee/getall', ['controller' => 'Employee', 'action' => 'getAll']);
        $builder->connect('/employee/get', ['controller' => 'Employee', 'action' => 'getById']);
        $builder->connect('/employee/create', ['controller' => 'Employee', 'action' => 'create']);

        $builder->connect('/product', ['controller' => 'Product', 'action' => 'index']);
        $builder->connect('/product/getall', ['controller' => 'Product', 'action' => 'getAll']);
        $builder->connect('/product/get', ['controller' => 'Product', 'action' => 'getById']);
        $builder->connect('/product/create', ['controller' => 'Product', 'action' => 'create']);

        $builder->connect('/sale', ['controller' => 'Sale', 'action' => 'index']);
        $builder->connect('/sale/create', ['controller' => 'Sale', 'action' => 'create']);
        $builder->connect('/saledetail/get', ['controller' => 'Sale', 'action' => 'getSaleDetailByIdSale']);
        $builder->connect('/sale/get', ['controller' => 'Sale', 'action' => 'getSaleById']);
        $builder->connect('/sale/getall', ['controller' => 'Sale', 'action' => 'getAll']);

        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/test', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    $routes->scope('/api', function (RouteBuilder $builder): void {
        $builder->connect('/customer/update', ['controller' => 'Customer', 'action' => 'update']);
        $builder->connect('/customer/delete', ['controller' => 'Customer', 'action' => 'delete']);

        $builder->connect('/employee/update', ['controller' => 'Employee', 'action' => 'update']);
        $builder->connect('/employee/delete', ['controller' => 'Employee', 'action' => 'delete']);

        $builder->connect('/product/update', ['controller' => 'Product', 'action' => 'update']);
        $builder->connect('/product/delete', ['controller' => 'Product', 'action' => 'delete']);

        $builder->connect('/saledetail/increase', ['controller' => 'Sale', 'action' => 'increaseProduct']);
        $builder->connect('/saledetail/decrease', ['controller' => 'Sale', 'action' => 'decreaseProduct']);

        $builder->connect('/sale/charge', ['controller' => 'Sale', 'action' => 'chargeSale']);
        $builder->connect('/sale/cancel', ['controller' => 'Sale', 'action' => 'cancelSale']);

    });


    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
