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
        $todayRecord = BestRecord::
            where('user_id', Auth::id())
            ->whereDate('recorded_on', $today)
            ->first();

        $pastRecords = BestRecord::
            where('user_id', Auth::id())
            ->where('recorded_on', '<', $today)
            ->orderBy('recorded_on', 'desc')
            ->paginate(10);

        return view('home',
        ['today' => $today,
        'todayRecord' => $todayRecord,
        'pastRecords' => $pastRecords,
        'categories' => config('categories'),
        'units' => config('units')]);
    }
}
