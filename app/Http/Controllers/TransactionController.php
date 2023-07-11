<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => ['required', 'exists:products,id'],
                'quantity' => ['required', 'integer', 'min:1'],
            ]);

            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => ['Stock is not sufficient for this product.'],
                ]);
            }

            $price = $product->price;
            $adminFee = $price * 0.05;
            $tax = $price * 0.1;
            $total = $price + $adminFee + $tax;

            $data = Transaction::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'price' => $price,
                'quantity' => $request->quantity,
                'admin_fee' => $adminFee,
                'tax' => $tax,
                'total' => $total,
            ]);

            // Kurangi stock barang
            $product->stock -= $request->quantity;
            $product->save();

            return ApiFormatter::createApi(200, 'success', $data);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showAdmin()
    {
        $data = Transaction::all();
        if($data) {
            return ApiFormatter::createApi(200, 'success upload data products', $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function scopeOwnedByUser(Request $request)
    {
    
        $userId = $request->input('user_id');
        $user = Transaction::find($userId);

        $data = Transaction::where('user_id', $userId)->get();
         
        if($data) {
            return ApiFormatter::createApi(200, 'Histoy Transaction from '. $userId, $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function detailTransactionAdmin($id) {
        $data = Transaction::find($id);

        if (!$id) {
            return response()->json(['message' => 'Transaction not found.'], 404);
        }

        return ApiFormatter::createApi(200, 'Success Found Detail Products', $data);
    }

    public function detailHistoryUser(Request $request, $id, Transaction $trans) {
        $userId = $request->input('user_id');
        $data = Transaction::find($id);

        if($userId === $trans->user_id){
            $data = Transaction::where('user_id', $userId);
        }
    
        return response()->json(['transaction' => $data]);
    }
}