<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Stripecontroller extends Controller
{
    public function session(Request $request)
{
    //$user         = auth()->user();
    $productItems = [];

    \Stripe\Stripe::setApiKey(config('stripe.sk'));

    foreach (session('cart') as $id => $details) {

        $product_name = $details['product_name'];
        $total = $details['price'];
        $quantity = $details['quantity'];

        // Format unit_amount correctly
        $unit_amount = intval($total * 100); // Convert to cents

        $productItems[] = [
            'price_data' => [
                'product_data' => [
                    'name' => $product_name,
                ],
                'currency'     => 'USD',
                'unit_amount'  => $unit_amount,
            ],
            'quantity' => $quantity
        ];
    }

    $checkoutSession = \Stripe\Checkout\Session::create([
        'line_items'            => $productItems, // Remove the unnecessary square brackets
        'mode'                  => 'payment',
        'allow_promotion_codes' => true,
        'metadata'              => [
            'user_id' => "0001"
        ],
        'customer_email' => "sufyanshahid427@gmail.com", //$user->email,
        'success_url' => route('success'),
        'cancel_url'  => route('cancel'),
    ]);

    return redirect()->away($checkoutSession->url);
}

public function success()
{
    return "Thanks for your order! You have just completed your payment. The seller will reach out to you as soon as possible.";
}

public function cancel()
{
    return view('cancel');
}

}
