<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        // Show report selection page
        return view('reports.index');
    }
    
    public function equipmentReport(): View
    {
        // Generate equipment report
        $equipmentData = [];
        
        return view('reports.equipment', ['equipmentData' => $equipmentData]);
    }
    
    public function maintenanceReport(): View
    {
        // Generate maintenance report
        $maintenanceData = [];
        
        return view('reports.maintenance', ['maintenanceData' => $maintenanceData]);
    }
}