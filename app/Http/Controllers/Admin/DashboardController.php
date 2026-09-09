<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_menu' => Menu::count(),
            'total_kategori' => Category::count(),
            'total_pesanan' => Order::count(),
            'pesanan_pending' => Order::where('status', 'pending')->count(),
            'pendapatan' => Order::where('status', 'selesai')->sum('total_price'),
        ];

        $pesananTerbaru = Order::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'pesananTerbaru'));
    }
}
