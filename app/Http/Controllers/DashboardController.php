<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $query = Transaction::get();

        $income = $query->where('type', 'income')->sum('amount');
        $purchases = $query->where('type', 'purchase')->sum('amount');
        $costOfSale = $query->where('type', 'cost_of_sale')->sum('amount');

        return response()->json([
            'income' => $income,
            'purchases' => $purchases,
            'costOfSale' => $costOfSale,
        ]);
    }
}
