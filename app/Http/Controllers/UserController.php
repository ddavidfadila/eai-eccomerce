<?php

namespace App\Http\Controllers;

use App\PublisherService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . request()->cookie('auth-token'),
        ])->get('http://127.0.0.1:8080/api/product');
        $productResponse = $response->json();
        
        $products = [];
         if(isset($productResponse['data'])){
            $products = $productResponse['data'];
        }

        return view('dashboard', compact('products'));
    }

    public function addCart(Request $request){
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . request()->cookie('auth-token'),
            ])->get("http://127.0.0.1:8080/api/product/$request->productId");
            
            $productRes = $response->json();
            $products = $productRes['data'];
            
            $body = [
                'userId' => auth()->user()->id,
                'productId' => $products['id'],
                'qty' => 1,
                'totalPrice' => $products['price']
            ];

            $mqService = new PublisherService();
            $mqService->cartPublish(json_encode($body));
            
            return redirect()->back();
        }catch(\Exception $e){
            dd($e);
        }
    }

    public function deleteCart(Request $request){
        $body = [
            "id" => $request->cartId
        ];

        $mqService = new PublisherService();
        $mqService->deleteCartPublish(json_encode($body));
            
        return redirect()->back();
    }
}
