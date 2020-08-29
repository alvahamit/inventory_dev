<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

/*
 * HomeController has "auth" Middleware in its constructor.
 * Controller index() method checks for user role to serve dashboard.
 */
Route::get('/home', 'HomeController@index')->name('home');

/*
 * Auth and Admin route group:
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth','admin']
    ], function(){
    
    Route::resource('/users', 'UsersController');
    Route::resource('/roles', 'UsersRolesController');
    //Ajax routes:
    Route::get('/admin/area-chart-data', 'HomeController@getCurrentYearChartDataByMonth')->name('admin.areachart.data');
});

/*
 * Auth route group:
 */
Route::group(['middleware' => 'auth'], function(){
    Route::resource('/products', 'ProductsController');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/measurements', 'MeasurementsController');
    Route::resource('/stores', 'StoresController');
    Route::resource('/countries', 'CountriesController');
    /*
    * Common routes for all users
    */
   Route::get('/stock', 'StockController@index')->name('stock');
   Route::resource('/suppliers', 'SuppliersController');
   Route::resource('/purchases', 'PurchasesController');
   Route::resource('/orders', 'OrdersController');
   Route::resource('/customers', 'CustomersController');
   Route::resource('/invoices', 'InvoiceController');
     Route::resource('/wastage', 'WastageController');
   Route::get('/create-invoice/{id}', 'InvoiceController@create')->name('create.invoice');
   //Route::get('/create-invoice/{id}', 'InvoiceController@createSampleInvoice')->name('sample.invoice.create');
   Route::resource('/challans', 'ChallanController');
   Route::get('/create-challan/{id}', 'ChallanController@create')->name('order.challan.create');
   Route::get('/transfer-challan', 'ChallanController@transfer')->name('transfer.challan.create');
   Route::get('/transfer-challan/{id}', 'ChallanController@showtrch')->name('show.trch');
   Route::get('/transfer/index', 'ChallanController@transferChallanIndex')->name('transfer.challan.index');
   Route::get('/sample-challan/index', 'ChallanController@sampleChallanIndex')->name('sample.challan.index');
   Route::get('/sample-invoice/index', 'InvoiceController@sampleInvoiceIndex')->name('sample.invoice.index');
   Route::resource('/mrs', 'MoneyReceiptController');
   Route::resource('/samples', 'SampleController');
   Route::resource('/leads', 'LeadsController');
   /*
    * For accounts personnel
    */
   Route::get('/accounts', 'CustomerAccountController@index')->name('customers.account');
   /*
    * Route for azax call within application
    */
   Route::POST('/purchases/getProdData','PurchasesController@myAzax')->name('get.product.data');
   Route::resource('/ajax-suppliers', 'Ajax\SuppliersController');
   Route::resource('/ajax-purchases', 'Ajax\PurchasesController');
   Route::get('/ajax-stock', 'Ajax\StockController@index')->name('ajax-stock.index');
   Route::get('/ajax-buyer-address', 'OrdersController@getAddress')->name('ajax-order.getaddress');
   Route::get('/ajax-order-product-options','OrdersController@getProducts')->name('ajax-order.get.product.options');
   Route::get('/ajax-order-get', 'OrdersController@getOrder')->name('ajax.order.get');
   Route::get('/get-order-for-invoice', 'OrdersController@getOrderForInvoice')->name('get.order.for.invoice');
   Route::DELETE('/rem-cust-add', 'CustomersController@removeAddress')->name('ajax-customer.remove.address');
   Route::get('/invoices-index-by-order', 'InvoiceController@indexByOrder')->name('invoices.index.by.order');
   Route::get('/get-order-for-challan', 'OrdersController@getOrderForChallan')->name('get.order.for.challan');
   Route::get('/challans-index-by-order', 'ChallanController@indexByOrder')->name('challans.index.by.order');
   Route::get('/get-store-stock', 'StoresController@getStoreProducts')->name('get.store.stock');
   Route::POST('/challans-store-transfer', 'ChallanController@storeTransfer')->name('challans.store.transfer');
   Route::get('/mr/get', 'MoneyReceiptController@getMr')->name('mr.ajax.get');
   Route::POST('leads/convert', 'LeadsController@convert')->name('convert.lead');
   Route::POST('user/activate', 'UsersController@activate')->name('activate.user');
   Route::POST('user/deactivate', 'UsersController@deactivate')->name('deactivate.user');
   
   /*
    * Printing routes
    */
   Route::post('/purchase/pdf','PurchasesController@pdf')->name('print.purchase');
   Route::post('/order/pdf','OrdersController@pdf')->name('print.order');
   Route::post('/order/dl','OrdersController@dlpdf')->name('dl.order');
   Route::post('/invoice/pdf','InvoiceController@pdf')->name('print.invoice');
   Route::post('/challan/pdf','ChallanController@pdf')->name('print.challan');
   Route::post('/trch/pdf','ChallanController@pdftrch')->name('print.trch');
   Route::post('/mr/pdf','MoneyReceiptController@pdf')->name('print.mr');
   Route::post('/wastage/pdf','WastageController@pdf')->name('print.wastage');
});

/*
 * Routes for auto reference codes:
 */
Route::get('/ref-no-for-sample', 'SampleController@getUniqueRefNo')->name('get.sample.ref');
Route::get('/ref-no-for-buy', 'PurchasesController@getUniqueRefNo')->name('get.buy.ref');
Route::get('/ref-no-for-order', 'OrdersController@getUniqueRefNo')->name('get.order.ref');
Route::get('/ref-no-for-invoice', 'InvoiceController@getUniqueRefNo')->name('get.invoice.ref');
Route::get('/ref-no-for-challan', 'ChallanController@getUniqueRefNo')->name('get.challan.ref');
Route::get('/ref-no-for-wastage', 'WastageController@getUniqueRefNo')->name('get.wastage.ref');



/*
 * Testing laravel
 */
Route::get('/test', 'HomeController@getPieChartData')->name('test');
//Route::get('test', ['uses'=>'TestController@index', 'as'=>'test.index']);
Route::view('/show-invoice', 'admin.invoice.show')->name('invoice.show');
