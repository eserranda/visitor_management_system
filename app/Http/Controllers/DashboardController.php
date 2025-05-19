<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\FutureVisitor;
use App\Models\Visitors;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $totalVisitorsActive = Visitors::where('status', 'visiting')->count();
        $totalVisitor = Visitors::where('status', 'completed')->count();
        $futureVisitors = FutureVisitor::where('status', 'pending')->count();
        $totalHouse = Address::count();
        $visitorActiveUser = Visitors::where('user_id', $userId)->where('status', 'visiting')->count();
        $totalvisitorUser = Visitors::where('user_id', $userId)->where('status', 'completed')->count();
        $futurevisitorUser = FutureVisitor::where('user_id', $userId)->where('status', 'pending')->count();
        return view('page.dashboard.index', compact('totalVisitorsActive', 'totalVisitor', 'futureVisitors', 'totalHouse', 'visitorActiveUser', 'totalvisitorUser', 'futurevisitorUser'));
    }
}
