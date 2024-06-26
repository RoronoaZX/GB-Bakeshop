<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchesProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class BranchesProductController extends Controller
{
    public function getProducts($branchId)
    {
        $branchProducts = BranchesProduct::where('branches_id', $branchId)->with(['branch', 'product'])->get();


        return response()->json($branchProducts, 200);
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'branches_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
        ]);

        $existingBranchProduct = BranchesProduct::where('branches_id', $validatedData['branches_id'])->where('product_id', $validatedData['product_id'])->first();

        if ($existingBranchProduct) {
            return response()->json([
                'message' => 'The product already exists in this branch.'
            ]);
        }

        $branchProduct = BranchesProduct::create([
            'branches_id' => $validatedData['branches_id'],
            'product_id' =>$validatedData['product_id'],
            'price' => $validatedData['price']
        ]);

        return response()->json([
            'mesasge' => "Branch product saved successfully",
            'data' => $branchProduct
        ], 201);
    }

    public function show(BranchesProduct $branchesProduct)
    {
        //
    }

    public function updatePrice(Request $request, $id)
    {
        $validatedData = $request->validate([
            'price' => 'required|integer',
        ]);

        $branchProduct = BranchesProduct::findorFail($id);
        $branchProduct->price = $validatedData['price'];
        $branchProduct->save();

        return response()->json(['message' => 'Price updated successfully', 'price' => $branchProduct]);
    }

    public function destroy($id)
    {
        $branchProduct = BranchesProduct::find($id);

        if (!$branchProduct) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $branchProduct->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);

    }

}
