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
 * Auth route group:
 */
Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::view('/v2', 'admin.dash')->name('admin.dash');
    Route::resource('/v2/products', 'ProductsController');
    Route::resource('/v2/categories', 'CategoriesController');
    Route::resource('/v2/measurements', 'MeasurementsController');
    Route::resource('/v2/stores', 'StoresController');
    Route::resource('/v2/countries', 'CountriesController');
    /*
    * Common routes for all users
    */
   Route::get('/v2/stock', 'StockController@index')->name('stock');
   Route::resource('/v2/suppliers', 'SuppliersController');
   Route::resource('/v2/purchases', 'PurchasesController');
   Route::resource('/v2/orders', 'OrdersController');
   Route::resource('/v2/customers', 'CustomersController');
   Route::resource('/v2/invoices', 'InvoiceController');
   Route::get('/v2/order-invoice-create/{id}', 'InvoiceController@create')->name('order.invoice.create');
   Route::resource('/v2/challans', 'ChallanController');
   Route::get('/v2/order-challan-create/{id}', 'ChallanController@create')->name('order.challan.create');
   Route::get('/v2/transfer-challan-create', 'ChallanController@transfer')->name('transfer.challan.create');
   Route::get('/v2/transfer-challan-index', 'ChallanController@trchIndex')->name('transfer.challan.index');
   Route::resource('/v2/mrs', 'MoneyReceiptController');
   /*
    * For accounts personnel
    */
   Route::get('/v2/accounts', 'CustomerAccountController@index')->name('customers.account');
   /*
    * Route for azax call within application
    */
   Route::POST('/v2/purchases/getProdData','PurchasesController@myAzax');
   Route::resource('/v2/ajax-suppliers', 'Ajax\SuppliersController');
   //Route::get('/v2/ajax-suppliers', 'Ajax\SuppliersController@index')->name('ajax.suppliers.index');
   Route::resource('/v2/ajax-purchases', 'Ajax\PurchasesController');
   //Route::get('/v2/ajax-purchases', 'Ajax\PurchasesController@index')->name('ajax.purchases.index');
   Route::get('/v2/ajax-stock', 'Ajax\StockController@index')->name('ajax-stock.index');
   Route::get('/v2/ajax-buyer-address', 'OrdersController@getAddress')->name('ajax-order.getaddress');
   Route::get('/v2/ajax-order-product-options','OrdersController@getProducts')->name('ajax-order.get.product.options');
   Route::get('/v2/ajax-order-get', 'OrdersController@getOrder')->name('ajax.order.get');
   Route::get('/v2/get-order-for-invoice', 'OrdersController@getOrderForInvoice')->name('get.order.for.invoice');
   Route::DELETE('/v2/customers', 'CustomersController@removeAddress')->name('ajax-customer.remove.address');
   Route::get('/v2/invoices-index-by-order', 'InvoiceController@indexByOrder')->name('invoices.index.by.order');
   Route::get('/v2/get-order-for-challan', 'OrdersController@getOrderForChallan')->name('get.order.for.challan');
   Route::get('/v2/challans-index-by-order', 'ChallanController@indexByOrder')->name('challans.index.by.order');
   Route::get('/v2/get-store-stock', 'StoresController@getStoreProducts')->name('get.store.stock');
   Route::POST('/v2/challans-store-transfer', 'ChallanController@storeTransfer')->name('challans.store.transfer');
   Route::get('/v2/mr/get', 'MoneyReceiptController@getMr')->name('mr.ajax.get');
   
   /*
    * Printing routes
    */
   Route::post('/purchase/pdf','PurchasesController@pdf')->name('print.purchase');
   Route::post('/order/pdf','OrdersController@pdf')->name('print.order');
   Route::post('/invoice/pdf','InvoiceController@pdf')->name('print.invoice');
   Route::post('/challan/pdf','ChallanController@pdf')->name('print.challan');
   Route::post('/mr/pdf','MoneyReceiptController@pdf')->name('print.mr');
});

/*
 * Auth and Admin route group:
 */
Route::group(['middleware' => ['auth','admin']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/v2/users', 'UsersController');
    Route::resource('/v2/roles', 'UsersRolesController');
    //Ajax routes:
    Route::get('/admin/area-chart-data', 'HomeController@getCurrentYearChartDataByMonth')->name('admin.areachart.data');
});



/*
 * Testing laravel
 */
Route::get('/test', 'HomeController@getPieChartData')->name('test');
//Route::get('test', ['uses'=>'TestController@index', 'as'=>'test.index']);
Route::view('/v2/show-invoice', 'admin.invoice.show')->name('invoice.show');




//use DataTables;

//Route::get('user-data', function() {
//    $collection = collect([
//        ['id' => 1, 'name' => 'John'],
//        ['id' => 2, 'name' => 'Jane'],
//        ['id' => 3, 'name' => 'James'],
//    ]);
//
//    return DataTables::of($collection)->toJson();
//});



//Route::get('/about', function () {
//    return "Todo view: about us page";
//});

//Route::get('/contact', function () {
//    return "Todo view: contact page";
//});

//Route::get('/admin', function () {
//    return view('backend');
//});

//Route::get('/items/contact', 'ItemsController@contact');


//Route::get('/stores', function(){
    /*
     * Save data using eloquent
     */
//    $store = new App\Store;
//    $store->name = "BADC";
//    $store->address = "Kawranbazaar";
//    $store->location = "Dhaka";
//    $store->contact_no = "02-9864422";
//    return var_dump($stores);
//    $store->save();
    /*
     * Get data by eloquent
     */
    //$stores = App\Store::all();
    //return $stores;
    //return var_dump($stores);

//});

//Route::get('/role/{id}/users', function($id){
//    $role = App\Role::find($id);
//    $users = $role->users()->get();
//    return $users;
//});

//Route::get('/test', 'TestController@index');
/*
 * End testing 
 */





