<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard.index');
    }

    public function getStatistics() {
        $newOrders = Order::select('id')->where(['status' => 1])->count();

        $result['success'] = true;
        $result['data']['countNewOrders'] = $newOrders;

        return response()->json($result);
    }
}
