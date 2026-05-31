<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get statistics from database
        $totalEquipment = 0;
        $totalMaintenance = 0;
        $pendingMaintenance = 0;
        $completedMaintenance = 0;
        
        // You'll populate these with actual queries after setting up models
        
        return view('dashboard.index', [
            'totalEquipment' => $totalEquipment,
            'totalMaintenance' => $totalMaintenance,
            'pendingMaintenance' => $pendingMaintenance,
            'completedMaintenance' => $completedMaintenance,
        ]);
    }
}