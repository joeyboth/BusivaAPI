<?php

namespace App\Http\Controllers;

use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Illuminate\Support\Facades\Auth;

class CreateSubscriptionController extends Controller
{
    /**
     * @param string $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(string $plan)
    {
        $user = Auth::user();
        $name = ucfirst($plan) . ' membership';
        
        if(!$user->subscribed($name, $plan)) {
            $redirect = $user->newSubscriptionViaMollieCheckout($name, $plan)->create();
            return $redirect;
        }

        return response()->json(["status"=>"You are already on the ' . $plan . ' plan"], 200);
    }
}
