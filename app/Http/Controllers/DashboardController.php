<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $total     = Inventory::count();
        $belowMin  = Inventory::with('modelType')->get()->filter(function ($item) {
            return $item->stock_quantity < ($item->modelType->minimum_stock ?? 0);
        })->count();
        $outStock  = Inventory::where('status', 'Out of Stock')->count();
        $chartData = Inventory::with('modelType')->get()->map(function($item){
            return [
                'inventory_name' => $item->inventory_name,
                'stock_quantity' => $item->stock_quantity,
                'minimum_stock'  => $item->modelType->minimum_stock ?? 0,
            ];
        });

        $recentActivities = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();

        return view('dashboard', compact(
            'total','belowMin','outStock','chartData','recentActivities'
        ));
    }
}
