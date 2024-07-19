<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Stripe;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_to_cart(Request $request, $id)
    {
        try {
            $user = User::findOrFail(Auth::user()->id);
            $product = Product::findOrFail($id);
            $cartItem = $user->carts()->where('product_id', $product->id)->first();

            if ($request->quantity > $product->quantity) {
                Alert::warning('Requested quantity exceeds available quantity');
                return redirect()->back();
            }

            if ($cartItem) {
                $newQuantity = $cartItem->pivot->quantity + $request->quantity;
                $price = $product->discount_price ?? $product->price;
                $totalPrice = $newQuantity * $price;

                $restQuantity = $product->quantity - $request->quantity;
                $product->update([
                    'quantity' => $restQuantity,
                ]);

                $user->carts()->updateExistingPivot($product->id, [
                    'quantity' => $newQuantity,
                    'price' => $totalPrice,
                ]);
            } else {
                $price = $product->discount_price ?? $product->price;
                $totalPrice = $request->quantity * $price;

                $restQuantity = $product->quantity - $request->quantity;
                $product->update([
                    'quantity' => $restQuantity,
                ]);

                $user->carts()->attach($product, [
                    'quantity' => $request->quantity,
                    'price' => $totalPrice,
                ]);
            }

            Alert::success('Product added to cart successfully.');

            return redirect()->back();

        } catch (\Exception $exception) {
            Alert::error('Failed to add product to cart. Please try again');
            return redirect()->back();
        }
    }

    public function show_cart()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('home.user.show_cart',compact('user'));
    }

    public function remove_from_cart($id)
    {
        try{
            $cart = Cart::findOrFail($id);
            $product =Product::findOrFail($cart->product_id);
            $availableQuantity = $product->quantity + $cart->quantity;
            $product->update([
                'quantity'=>$availableQuantity,
            ]);
            $cart->delete();
            Alert::success('Product Deleted Successfully');
            return redirect()->back();
        }catch (\Exception $exception){
            Alert::error('Failed to delete product. Please try again.');
            return redirect()->back();
        }
    }

    public function order_cash()
    {
        try{
            $userId = Auth::user()->id;
            $datas = Cart::where('user_id',$userId)->get();
            foreach ($datas as $data){
                $order = Order::create([
                    'quantity'=>$data->quantity,
                    'price'=>$data->price,
                    'user_id'=>$data->user_id,
                    'product_id'=>$data->product_id,
                    'payment_status'=>'cash on delivery',
                    'delivery_status'=>'processing',
                ]);
                $data->delete();
            }
            Alert::success('We Received Your Order Successfully.');
            return redirect()->back();
        }catch (\Exception $exception){
            Alert::error('We Did not Receive Your Order. Please try again.');
            return redirect()->back();
        }
    }

    public function stripe($totalprice)
    {
        return view('home.user.stripe',compact('totalprice'));
    }

    public function stripePost(Request $request,$totalprice)
    {
        try{
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment"
            ]);

            $userId = Auth::user()->id;
            $datas = Cart::where('user_id',$userId)->get();
            foreach ($datas as $data){
                $order = Order::create([
                    'quantity'=>$data->quantity,
                    'price'=>$data->price,
                    'user_id'=>$data->user_id,
                    'product_id'=>$data->product_id,
                    'payment_status'=>'paid',
                    'delivery_status'=>'processing',
                ]);
                $data->delete();
            }

            session()->flash('success', 'Payment successful!');
            return back();

        }catch (\Exception $exception){
            return redirect()->route('show.cart')->with('error', 'We Did not Receive Your Order. Please try again.');
        }
    }

    public function show_orders()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('home.user.show_orders',compact('user'));
    }

    public function cancel_order($id)
    {
        try{
            $order = Order::findOrFail($id);
            $order->delete();
            Alert::success('Order Canceled Successfully.');
            return redirect()->back();
        }catch (\Exception $exception){
            Alert::error('Failed to Cancel Order. Please try again.');
            return redirect()->back();
        }
    }

    public function add_comment(Request $request)
    {
        try{
            $data = $request->validate([
                'comment'=>'required',
            ]);
            $comment = new Comment();
            $comment->comment = $data['comment'];
            $comment->user_id = auth()->user()->id;
            $comment->save();
            Alert::success('Comment Posted Successfully.');
            return redirect()->back();
        }catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors()->all())->withInput();
        } catch (\Exception $exception){
            Alert::error('Failed to Post Comment. Please try again.');
            return redirect()->back();
        }
    }

    public function add_reply(Request $request)
    {
        try{
            $data = $request->validate([
                'reply'=>'required',
                'commentId'=>'required',
            ]);
            $reply = new Reply();
            $reply->reply = $data['reply'];
            $reply->comment_id = $data['commentId'];
            $reply->user_id = auth()->user()->id;
            $reply->save();
            Alert::success('Reply Posted Successfully.');
            return redirect()->back();

        }catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors()->all())->withInput();
        } catch (\Exception $exception){
            Alert::error('Failed to Post Reply. Please try again.');
            return redirect()->back();
        }
    }

}
