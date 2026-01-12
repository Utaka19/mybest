<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BestRecordController extends Controller
{
    public function create()
    {
        $today = date('Y-m-d');
        return view('records.create', ['today' => $today, 'categories' => config('categories')]);
    }
}
