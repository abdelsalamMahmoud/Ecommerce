<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Climate\Order;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        $comments = Comment::orderby('created_at','DESC')->get();
        return view('home.userpage',compact('products','comments'));
    }

    public function redirect()
    {
        $userType = Auth::user()->userType;

        if ($userType == '1')
        {
            $total_products_number = Product::all()->count();
            $total_customers_number = User::where('userType',0)->count();
            return view('admin.home',compact('total_products_number','total_customers_number'));
        }
        else
        {
            $products = Product::paginate(10);
            $comments = Comment::orderby('created_at','DESC')->get();
            return view('home.userpage',compact('products','comments'));
        }
    }

    public function show_product_details($id)
    {
        $product = Product::findOrFail($id);
        return view('home.product_details',compact('product'));
    }

    public function search_product(Request $request)
    {
        $search = $request['search'];
        $products = Product::where('title', 'LIKE', "%$search%")
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->paginate(10);
        $comments = Comment::orderby('created_at','DESC')->get();
        return view('home.userpage',compact('products','comments'));

    }

    public function show_product()
    {
        $products = Product::paginate(10);
        $comments = Comment::orderby('created_at','DESC')->get();
        return view('home.all_products',compact('products','comments'));
    }
}
