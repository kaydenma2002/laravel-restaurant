<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\StripeInterface;
use App\Models\Menu;
use Stripe;
class StripeRepository implements StripeInterface
{
    public function stripePost($request){
        try{
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
              );
              $res = $stripe->tokens->create([
                'card' => [
                  'number' => $request->number,
                  'exp_month' => $request->exp_month,
                  'exp_year' => $request->exp_year,
                  'cvc' => $request->cvc,
                ],
              ]);
              Stripe\Stripe::setApiKey(env('SRIPE_SECRET'));
              $response = $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $res->id,
                'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
              ]);
              return response()->json([$response->status]);
        }
        catch(\Exception $e){
            return response()->json(['response' => $e->getMessage()]);
        }
    }
}