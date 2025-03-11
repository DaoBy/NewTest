<?php

namespace App\Http\Controllers;

use App\Models\PriceMatrix;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceMatrixController extends Controller
{
    // Show admin form
    public function edit()
    {
        $priceMatrix = PriceMatrix::first();
        return Inertia::render('Admin/PriceMatrix', [
            'priceMatrix' => $priceMatrix,
        ]);
    }

    // Update price matrix
    public function update(Request $request)
    {
        $request->validate([
            'base_fee' => 'required|numeric|min:0',
            'volume_rate' => 'required|numeric|min:0',
            'weight_rate' => 'required|numeric|min:0',
            'package_rate' => 'required|numeric|min:0',
        ]);

        $priceMatrix = PriceMatrix::first();
        $priceMatrix->update($request->all());

        return redirect()->back()->with('success', 'Price Matrix updated!');
    }

    // Fetch matrix for customer form
    public function index()
    {
        return response()->json(['priceMatrix' => PriceMatrix::first()]);
    }
}
