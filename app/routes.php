<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

if (Config::get('database.log', false))
{           
    Event::listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding)
        {   
            if ($binding instanceof \DateTime)
            {   
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            }
            else if (is_string($binding))
            {   
                $bindings[$i] = "'$binding'";
            }   
        }       

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings); 

        Log::info($query, $data);
    });
}

Route::get('/', 'HomeController@login')->before('guest');

Route::post('/login', 'HomeController@postlogin')->before('redirect|guest|logging');

Route::get('reminders', 'RemindersController@index'); //can be used as resource but now only used to send out reminder emails

Route::group(array('before' => 'redirect|logging|auth|salesperson'), function() {

	//permissions for salespeople

	Route::get('ajax/ordered', array('as' => 'ajax.ordered', 'uses' => 'OrderController@getOrdered'));

	Route::get('ajax/received', array('as' => 'ajax.received', 'uses' => 'OrderController@getReceived'));

	Route::get('ajax/pickup', array('as' => 'ajax.pickup', 'uses' => 'OrderController@getPickUp'));

	Route::get('ajax/order/removed', array('as' => 'ajax.order.removed', 'uses' => 'OrderController@getRemoved'));

	Route::controller('ajax/customer', 'CustomersController');

	Route::controller('ajax/equipment', 'EquipmentController');

	Route::get('work/history', array('as' => 'work.history', 'uses' => 'JobsController@getHistory'));

	Route::get('orders/history', array('as' => 'orders.history', 'uses' => 'OrderController@getHistory'));

	Route::any('equipment/multi', array('as' => 'equipment.storemultiple', 'uses' => 'EquipmentController@storemultiple'));

	Route::resource('customer', 'CustomersController');

	Route::resource('equipment', 'EquipmentController');

	Route::resource('orders', 'OrderController');

	Route::resource('purchases', 'PurchaseController');
});

Route::group(array('before' => 'redirect|logging|auth'), function() {

	//permissions for everyone

	Route::any('logout', array('as' => 'users.logout', 'uses' => 'HomeController@logout'));

	Route::post('ajax/engineer', array('as' => 'ajax.engineer', 'uses' => 'JobsController@postEngineer'));

	Route::get('ajax/job/removed', array('as' => 'ajax.job.removed', 'uses' => 'JobsController@getRemoved'));

	Route::get('ajax/part/removed', array('as' => 'ajax.part.removed', 'uses' => 'JobsController@getPartRemoved'));

	Route::get('ajax/started', array('as' => 'ajax.started', 'uses' => 'JobsController@getStarted'));

	Route::get('ajax/completed', array('as' => 'ajax.complete', 'uses' => 'JobsController@getCompleted'));

	Route::get('ajax/waiting', array('as' => 'ajax.waiting', 'uses' => 'JobsController@getWaiting'));

	Route::get('ajax/contacted', array('as' => 'ajax.contact', 'uses' => 'JobsController@getContacted'));

	Route::get('ajax/paid', array('as' => 'ajax.paid', 'uses' => 'JobsController@getPaid'));

	Route::get('changeuser', array('as' => 'changeuser', 'uses' => 'HomeController@changeUser'));

	Route::post('changeuser', array('as' => 'post.changeuser', 'uses' => 'HomeController@user'));

	Route::resource('work', 'JobsController'); 

});

Route::group(array('before' => 'redirect|logging|auth|admin'), function() {

	Route::resource('users', 'UsersController');

	Route::resource('parts', 'PartsController');

	Route::resource('types', 'TypesController');

	Route::get('report', array('as' => 'reports.index', 'uses' => 'ReportsController@index'));

	Route::get('report/hours', array('as' => 'reports.users', 'uses' => 'ReportsController@users'));

	Route::get('export', array('as' => 'export', 'uses' => 'ExportController@index'));

	Route::post('export', array('as' => 'export.export', 'uses' => 'ExportController@export'));

});