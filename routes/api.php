<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('edit_product_image', [CustomerController::class, 'addProductImage']);
Route::get('customers/{company_id}/{salesman_id}', [CustomerController::class, 'customers']);
Route::get('kashfs_cust/{cust_id}/{comp_id}', [CustomerController::class, 'getKashfRedirect']);
Route::get('get_specefic_product/{id}/{company_id}', [CustomerController::class, 'get_specefic_product']);
Route::get('search_products_barcode/{company_id}/{id}', [CustomerController::class, 'search_products_barcode']);
Route::get('categories/{company_id}', [CustomerController::class, 'categories']);
Route::get('qabds/{company_id}/{salesman_id}', [CustomerController::class, 'qabds']);
Route::get('sarfs/{company_id}/{salesman_id}', [CustomerController::class, 'sarfs']);
Route::get('/customers/{company_id}/{salesman_id}/search', [CustomerController::class, 'filter']);
Route::get('/customers/{company_id}/{salesman_id}/{name}', [CustomerController::class, 'filterCustomersByName']);
Route::get('products/{company_id}/{category_id}/{salesman_id}/{customer_id}/{price_code}', [CustomerController::class, 'products']);
Route::get('allProducts/{company_id}/{salesman_id}/{customer_id}/{price_code}', [CustomerController::class, 'allProducts']);
Route::get('statments/{company_id}/{customer_id}', [CustomerController::class, 'statments']);
Route::get('invoices', [CustomerController::class, 'invoices']);
Route::get('get_orders', [CustomerController::class, 'get_orders']);
Route::get('orders/{company_id}/{salesman_id}', [CustomerController::class, 'orders']);
Route::get('receipts/{company_id}/{salesman_id}', [CustomerController::class, 'receipts']);
Route::get('search/{id}/{company_id}/{salesman_id}', [CustomerController::class, 'search']);
Route::get('search_products/{id}/{company_id}/{salesman_id}/{customer_id}/{price_code}', [CustomerController::class, 'search_products']);
Route::get('orderdetails/{id}/{company_id}/{salesman_id}', [CustomerController::class, 'orderdetails']);
Route::get('getkashfs/{id}/{company_id}/{salesman_id}/{f_code}', [CustomerController::class, 'getkashfs']);
Route::post('add_order', [CustomerController::class, 'add_order']);
Route::post('add_catch_receipt', [CustomerController::class, 'add_catch_receipt']);
Route::post('addFatora', [CustomerController::class, 'addFatora']);
Route::post('addchk', [CustomerController::class, 'addcheek']);
Route::get('invoiceproducts/{company_id}/{salesman_id}', [CustomerController::class, 'invoiceproducts']);
Route::get('check_invoiceproducts/{company_id}/{salesman_id}/{customer_id}/{product_id}', [CustomerController::class, 'check_invoiceproducts']);
Route::get('get_price_barcode/{company_id}/{salesman_id}/{customer_id}/{product_id}', [CustomerController::class, 'getPriceBarcode']);
Route::post('remove_fatora', [CustomerController::class, 'remove_fatora']);
Route::post('edit_fatora', [CustomerController::class, 'edit_fatora']);
Route::post('edit_user', [CustomerController::class, 'edit_user']);
Route::post('delete_user/{user_id}', [CustomerController::class, 'delete_user']);
Route::get('filter_orders/{company_id}/{salesman_id}', [CustomerController::class, 'filter_orders']);
Route::get('filter_qabds/{company_id}/{salesman_id}', [CustomerController::class, 'filter_qabds']);
Route::get('filter_sarfs/{company_id}/{salesman_id}', [CustomerController::class, 'filter_sarfs']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
