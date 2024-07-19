<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PDF;
use Notification;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function category()
    {
        $categories = Category::paginate(5);
        return view('admin.category',compact('categories'));
    }
    public function add_category(Request $request){
        try{
            $data = $request->validate([
                'name'=>'required',
            ]);
            $category = new Category();
            $category->name = $data['name'];
            $category->save();
            return redirect()->back()->with('message','Category Added Successfully');

        }catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors()->all())->withInput();
        } catch (\Exception $exception){
            return redirect()->back()->with('error', 'Failed to add category. Please try again.');
        }
    }

    public function delete_category($id){
        try{
            $category = Category::findOrFail($id);
            $category->products()->delete();
            $category->delete();
            return redirect()->back()->with('message','Category Deleted Successfully');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Failed to delete category. Please try again.');
        }
    }

    public function create_product(){
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    public function add_product(Request $request) {
        try {
            $data = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'quantity' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'category' => 'required',
            ]);

            $product = new Product();

            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->discount_price = $data['discount_price'];
            $product->quantity = $data['quantity'];
            $product->category_id = $data['category'];

            $image = $data['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('products', $imageName);
            $product->image = $imageName;

            $product->save();

            return redirect()->back()->with('message', 'Product added successfully');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors()->all())->withInput();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Failed to add product. Please try again.');
        }
    }

    public function show_products()
    {
        $products = Product::paginate(5);
        return view('admin.products.index',compact('products'));
    }

    public function delete_product($id)
    {
        try{
            $product = Product::findOrFail($id);
            if ($product->image) {
                $imagePath = public_path('products/' . $product->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $product->delete();
            return redirect()->back()->with('message','product Deleted Successfully');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit',compact('product','categories'));
    }

    public function update_product(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'quantity' => 'required|integer',
                'image' => 'image|mimes:jpeg,png,jpg,gif',
                'category' => 'required',
            ]);

            $product = Product::findOrFail($id);
            if ($request->hasFile('image')) {
                if ($product->image) {
                    $imagePath = public_path('products/' . $product->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $image = $data['image'];
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move('products', $imageName);
                $product->image = $imageName;
            }

            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->discount_price = $data['discount_price'];
            $product->quantity = $data['quantity'];
            $product->category_id = $data['category'];

            $product->save();

            return redirect()->back()->with('message', 'Product updated successfully');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors()->all())->withInput();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function show_orders()
    {
        $orders = Order::all();
        return view('admin.orders',compact('orders'));
    }

    public function deliver($id)
    {
        try{
            $order = Order::findOrFail($id);
            $order->update([
                'delivery_status'=>'delivered',
                'payment_status'=>'paid',
            ]);
            return redirect()->back()->with('message','Order Delivered Successfully');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Failed to Deliver Order. Please try again.');
        }
    }

    public function print_pdf($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadview('admin.pdf',compact('order'));
        return $pdf->download('order_details.pdf');

    }

    public function send_email($id)
    {
        $user = User::findOrFail($id);
        return view('admin.email_info',compact('user'));
    }

    public function send_user_email(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'greeting' => 'required',
                'firstline' => 'required',
                'body' => 'required',
                'button' => 'required',
                'url' => 'required|url',
                'lastline' => 'required',
            ]);

            $user = User::findOrFail($id);
            $details = [
                'greeting' => $validatedData['greeting'],
                'firstline' => $validatedData['firstline'],
                'body' => $validatedData['body'],
                'button' => $validatedData['button'],
                'url' => $validatedData['url'],
                'lastline' => $validatedData['lastline'],
            ];

            Notification::send($user, new SendEmailNotification($details));

            return redirect()->back()->with('message', 'Email Sent Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function search_data(Request $request)
    {
        $search = $request['search'];

        $orders = Order::whereHas('user', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->get();

        return view('admin.orders',compact('orders'));

    }

}
