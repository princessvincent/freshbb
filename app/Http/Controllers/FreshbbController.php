<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\Request;

class FreshbbController extends Controller
{
    public function uploadprod(Request $request)
    {
        $request->validate([
            'prod_name' => 'required',
            'prod_amount' => 'required',
            'prod_quantity' => 'required',
            'prod_description' => 'required',
            'prod_picture' => 'required',
        ]);

        $prod = new Product;
        $prod->prod_name = $request->prod_name;
        $prod->prod_amount = $request->prod_amount;
        $prod->prod_quantity = $request->prod_quantity;
        $prod->prod_description = $request->prod_description;

        if($request->hasFile('prod_picture'))
        {
            $file = $request->file('prod_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('products/', $filename);
            $prod->prod_picture = $filename;
        }

        // $prod->save();
        if($prod->save()){
            return response()->json([
                'statusCode' => 200,
                'message' => 'Product saved successfully'
            ]);
        }else{
            return response()->json([
                'statusCode' => 422,
                'message' => 'Unable to upload Product successfully'
            ]);
        }
    }

    public function viewprod()
    {
        $getprod = Product::all();

        return response()->json([
            'statusCode' => 200,
            'message' => $getprod
        ]);
    }

    public function faq(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faq = new Faq;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        if($faq->save())
        {
            return response()->json([
                'statusCode' => 200,
                'message' => 'Faq saved successfully'
            ]);
        }else{
            return response()->json([
                'statusCode' => 422,
                'message' => 'Unable to save Faq'
            ]);
        }
    }

    public function viewfaq()
    {
        $getfaq = Faq::all();

        return response()->json([
            'statusCode' => 200,
            'message' => $getfaq

        ]);
    }

    public function review(Request $request)
    {
        $request->validate([
            'prod_id' => 'required',
            'review' => 'required'
        ]);

        $review = new Reviews;

        $review->user_id = 1;
        $review->prod_id = $request->prod_id;
        $review->review = $request->review;
        $review->save();

        if($review->save())
        {
            return response()->json([
                'statusCode' => 200,
                'message' => 'Review saved successfully'
            ]);
        }else{
            return response()->json([
                'statusCode' => 422,
                'message' => 'Unable to save Review'
            ]);
        }

    }

    public function viewreview($id)
    {
        $getreview = Reviews::where('prod_id', $id)->get();
        return response()->json([
            'statusCode' => 200,
            'message' => $getreview

        ]);
    }

}
