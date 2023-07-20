<?php

namespace App\Http\Controllers;

use Exception;
use Stripe\Token;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Payment;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;


class PaymentController extends Controller
{

    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
        ]);

        try {
            $stripe = new StripeClient(
                env('STRIPE_SECRET'),
            );
            // $res =  $stripe->tokens->create([
            //     'card' => [
            //         'number' => 'tok_visa',
            //         'exp_month' => 8,
            //         'exp_year' => 2024,
            //         'cvc' => '314',
            //     ],
            // ]);

            \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

         $res =   $stripe->tokens->create(array(
                "card" => array(
                    "number" => $request->number,
                    "exp_month" => $request->exp_month,
                    "exp_year" => $request->exp_year,
                    "cvc" => $request->cvc
                )
            ));


            Stripe::setApiKey(env('STRIPE_SECRET'));

            $response =  $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'myr',
                'source' => $res->id,
                'description' => $request->description,
            ]);

            $savepayment = new Payment;
            $savepayment->email = $request->email;
            $savepayment->payment_type = $res->type;
            $savepayment->payment_id = $res->id;
            $savepayment->amount = $request->amount;
            $savepayment->currency = 'NG';
            $savepayment->description = $request->description;
            $savepayment->save();

            return response()->json([
                'status' => $response->status,
                'message' => 'Payment Integration was Successful',
                'data' => $res
            ], 201);
        } catch (Exception  $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
