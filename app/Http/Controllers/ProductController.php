<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product; 
 
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }
 
    public function cart()
    {
        return view('cart');
    }
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
 
        $cart = session()->get('cart', []);            // if data/id not find  then cart will be show empty 
 
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }  else {
            $cart[$id] = [
                "product_name" => $product->product_name,
                "photo" => $product->photo,
                "price" => $product->price,
                "quantity" => 1
            ];
        }
 
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product add to cart successfully!');
    }
 
    public function update(Request $request)
    {
        if($request->id && $request->quantity){ // check condition if both field alredy exist
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity; // "quantity"  ye value cart main majood  value request main di gai value  main change krti hy

            session()->put('cart', $cart);
            session()->flash('success', 'Cart successfully updated!');
        }
    }
 
    public function remove(Request $request)
    {
        if($request->id) {    // agr request main id majood ho gi tuh curly braces block execute ho ga
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart); // ye line cart main dubara session main update krti hy jb cart sy item del kia jata hy
            }
            session()->flash('success', 'Product successfully removed!'); // it is use to flash message
        }
    }
}
