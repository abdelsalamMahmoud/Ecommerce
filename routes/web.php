<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

######################## start Home routes ###############################
Route::get('/',[HomeController::class,'index']);
Route::get('/redirect',[HomeController::class,'redirect'])->middleware('auth','verified');
Route::get('/product_details/{id}',[HomeController::class,'show_product_details'])->name('product.details');
Route::get('/product_search',[HomeController::class,'search_product'])->name('product.search');
Route::get('/product',[HomeController::class,'show_product'])->name('product');
######################## start Home routes ###############################


####################### start Admin routes ###############################

####################### Start Category routes ###############################
Route::get('/category',[AdminController::class,'category'])->name('category');
Route::post('/category_add',[AdminController::class,'add_category'])->name('category.add');
Route::get('/category_delete/{id}',[AdminController::class,'delete_category'])->name('category.delete');
####################### End Category routes ###############################

####################### Start Product routes ###############################
Route::get('/products_show',[AdminController::class,'show_products'])->name('products.show');
Route::get('/product_create',[AdminController::class,'create_product'])->name('product.create');
Route::post('/product_add',[AdminController::class,'add_product'])->name('product.add');
Route::get('/product_delete/{id}',[AdminController::class,'delete_product'])->name('product.delete');
Route::get('/product_edit/{id}',[AdminController::class,'edit_product'])->name('product.edit');
Route::patch('/product_update/{id}', [AdminController::class, 'update_product'])->name('product.update');
####################### End Product routes ###############################

####################### Start Orders routes ###############################
Route::get('/orders_show',[AdminController::class,'show_orders'])->name('orders.show');
Route::get('/deliver/{id}',[AdminController::class,'deliver'])->name('deliver');
####################### End Orders routes ###############################

Route::get('/print_pdf/{id}',[AdminController::class,'print_pdf'])->name('print.pdf');
Route::get('/send_email/{id}',[AdminController::class,'send_email'])->name('send.email');
Route::post('/send_user_email/{id}',[AdminController::class,'send_user_email'])->name('send.user.email');
Route::get('/search',[AdminController::class,'search_data'])->name('search');

#######################End Admin routes ###############################


######################## start User routes ###############################
Route::post('/add_to_cart/{id}',[UserController::class,'add_to_cart'])->name('add.to.cart');
Route::get('/show_cart',[UserController::class,'show_cart'])->name('show.cart');
Route::get('/remove_from_cart/{id}',[UserController::class,'remove_from_cart'])->name('remove.from.cart');
Route::get('/order_cash',[UserController::class,'order_cash'])->name('order.cash');
Route::get('/show_orders',[UserController::class,'show_orders'])->name('show.orders');
Route::get('/cancel_order/{id}',[UserController::class,'cancel_order'])->name('cancel.order');
// for paying using card
Route::get('/stripe/{totalprice}',[UserController::class,'stripe'])->name('stripe');
Route::post('stripe/{totalprice}', [UserController::class,'stripePost'])->name('stripe.post');
//end paying using card

//for comments
Route::post('add_comment', [UserController::class,'add_comment'])->name('comment.add');
Route::post('add_reply', [UserController::class,'add_reply'])->name('reply.add');
//end comments

######################## End User routes ###############################
