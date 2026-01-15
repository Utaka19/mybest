<?php

namespace App\Http\Controllers;

use App\Models\BestRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $todayRecord = BestRecord::where('user_id', Auth::id())
            ->where('recorded_on', $today)
            ->first();

        return view('home', ['today' => $today, 'todayRecord' => $todayRecord, 'categories' => config('categories')]);
    }
}
