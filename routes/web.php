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
    'prefix' => 'app',
    'middleware' => ['auth','admin']
    ], function(){
    Route::resource('/measurements', 'MeasurementsController');
    Route::resource('/countries', 'CountriesController');
    Route::resource('/users', 'UsersController');
    Route::resource('/roles', 'UsersRolesController');
    //Ajax routes:
    Route::get('/admin/area-chart-data', 'HomeController@getCurrentYearChartDataByMonth')->name('admin.areachart.data');
});

Route::group([
    'prefix' => 'procure',
    'middleware' => ['auth', 'proc']
    ], function(){
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/products', 'ProductsController');
    Route::resource('/suppliers', 'SuppliersController');
    Route::resource('/buy', 'PurchasesController');
    //Unique number:
    Route::get('/ref-no-for-buy', 'PurchasesController@getUniqueRefNo')->name('get.buy.ref');
});

Route::group([
    'prefix' => 'sales',
    'middleware' => ['auth','sales']
    ], function(){
    Route::resource('/customers', 'CustomersController');
    Route::resource('/orders', 'OrdersController');
    Route::get('/orders/{id}/hold', 'OrdersController@hold')->name('hold.order');
    Route::get('/orders/{id}/cancel', 'OrdersController@cancel')->name('cancel.order');
    //Unique no:
    Route::get('/ref-no-for-order', 'OrdersController@getUniqueRefNo')->name('get.order.ref');
    
});

Route::group([
    'prefix' => 'marketing',
    'middleware' => ['auth','mkt']
    ], function(){
    Route::resource('/samples', 'SampleController');
    Route::resource('/leads', 'LeadsController');
    //Unique number:
    Route::get('/ref-no-for-sample', 'SampleController@getUniqueRefNo')->name('get.sample.ref');
});

Route::group([
    'prefix' => 'acc',
    'middleware' => ['auth', 'acc']
    ], function(){
    Route::resource('/invoices', 'InvoiceController');
    Route::resource('/mrs', 'MoneyReceiptController');
    Route::get('/orders', 'OrdersController@ordersForAcc')->name('orders.for.accounts');
    Route::get('/orders/{id}', 'OrdersController@showOrderForAcc')->name('showorder.for.accounts');
    Route::get('/create-invoice/{id}', 'InvoiceController@create')->name('create.invoice');
    Route::get('/cust-stat', 'CustomerAccountController@index')->name('customers.account');
    Route::get('/sample-invoice/index', 'InvoiceController@sampleInvoiceIndex')->name('sample.invoice.index');
    //Unique no:
    Route::get('/ref-no-for-invoice', 'InvoiceController@getUniqueRefNo')->name('get.invoice.ref');
    
});

Route::group([
    'prefix' => 'store',
    'middleware' => ['auth','store']
    ], function(){
    Route::resource('/stores', 'StoresController');
    Route::resource('/challans', 'ChallanController');
    Route::resource('/wastage', 'WastageController');
    Route::get('/stock', 'StockController@index')->name('stock');
    Route::get('/orders', 'OrdersController@ordersForStore')->name('orders.for.store');
    Route::get('/orders/{id}', 'OrdersController@showOrderForStore')->name('showorder.for.store');
    Route::get('/challan/{id}', 'ChallanController@create')->name('order.challan.create');
    Route::get('/transfer-challan', 'ChallanController@transfer')->name('transfer.challan.create');
    Route::get('/transfer-challan/{id}', 'ChallanController@showtrch')->name('show.trch');
    Route::get('/transfer/index', 'ChallanController@transferChallanIndex')->name('transfer.challan.index');
    Route::get('/sample-challan/index', 'ChallanController@sampleChallanIndex')->name('sample.challan.index');
    
    
    //Unique number:
    Route::get('/ref-no-for-challan', 'ChallanController@getUniqueRefNo')->name('get.challan.ref');
    Route::get('/ref-no-for-wastage', 'WastageController@getUniqueRefNo')->name('get.wastage.ref');
    
});

Route::group([
    'prefix' => 'pdf',
    'middleware' => ['auth']
    ], function(){
    Route::post('/invoice','InvoiceController@pdf')->name('print.invoice');
    Route::post('/mr','MoneyReceiptController@pdf')->name('print.mr');
    Route::post('/order','OrdersController@pdf')->name('print.order');
    Route::post('/order/dl','OrdersController@dlpdf')->name('dl.order');
    Route::post('/buy','PurchasesController@pdf')->name('print.purchase');
    Route::post('/challan','ChallanController@pdf')->name('print.challan');
    Route::post('/challan/transfer','ChallanController@pdftrch')->name('print.trch');
    Route::post('/wastage','WastageController@pdf')->name('print.wastage');
});

Route::group([
    'prefix' => 'ajax',
    'middleware' => ['auth']
    ], function(){
    Route::POST('/getProdData','PurchasesController@myAzax')->name('get.product.data');
    //Route::resource('/suppliers', 'Ajax\SuppliersController');
    //Route::resource('/purchases', 'Ajax\PurchasesController');
    Route::get('/stock', 'Ajax\StockController@index')->name('ajax-stock.index');
    Route::get('/buyer-address', 'OrdersController@getAddress')->name('ajax-order.getaddress');
    Route::get('/order-product-options','OrdersController@getProducts')->name('ajax-order.get.product.options');
    Route::get('/order-get', 'OrdersController@getOrder')->name('ajax.order.get');
    Route::get('/get-order-for-invoice', 'OrdersController@getOrderForInvoice')->name('get.order.for.invoice');
    Route::DELETE('/rem-cust-add', 'CustomersController@removeAddress')->name('ajax-customer.remove.address');
    Route::get('/invoices-index-by-order', 'InvoiceController@indexByOrder')->name('invoices.index.by.order');
    Route::get('/get-order-for-challan', 'OrdersController@getOrderForChallan')->name('get.order.for.challan');
    Route::get('/challans-index-by-order', 'ChallanController@indexByOrder')->name('challans.index.by.order');
    Route::get('/get-store-stock', 'StoresController@getStoreProducts')->name('get.store.stock');
    Route::POST('/challans-store-transfer', 'ChallanController@storeTransfer')->name('challans.store.transfer');
    Route::get('/mr-get', 'MoneyReceiptController@getMr')->name('mr.ajax.get');
    Route::POST('/leads-convert', 'LeadsController@convert')->name('convert.lead');
    Route::POST('/user-activate', 'UsersController@activate')->name('activate.user');
    Route::POST('/user-deactivate', 'UsersController@deactivate')->name('deactivate.user');
});



/*
 * Testing laravel
 */
Route::get('/test', 'HomeController@getPieChartData')->name('test');
//Route::get('test', ['uses'=>'TestController@index', 'as'=>'test.index']);
Route::view('/show-invoice', 'admin.invoice.show')->name('invoice.show');
