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
        $current_user_id = Auth::id();
        $today = now()->toDateString();
        $today_record = BestRecord::where('user_id', $current_user_id)
                                    ->where('recorded_on', $today)
                                    ->first();
        return view('home', ['today' => $today, 'today_record' => $today_record, 'categories' => config('categories')]);
    }
}
