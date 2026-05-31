<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EquipmentController extends Controller
{
    public function index(): View
    {
        // Fetch all equipment from database
        $equipment = [];
        
        return view('equipment.index', ['equipment' => $equipment]);
    }
    
    public function create(): View
    {
        return view('equipment.create');
    }
    
    public function store(): RedirectResponse
    {
        // Store equipment in database
        return redirect()->route('equipment.index')->with('success', 'Equipment created successfully');
    }
    
    public function show(string $id): View
    {
        // Fetch single equipment
        return view('equipment.show', ['equipment' => []]);
    }
    
    public function edit(string $id): View
    {
        // Fetch equipment for editing
        return view('equipment.edit', ['equipment' => []]);
    }
    
    public function update(string $id): RedirectResponse
    {
        // Update equipment in database
        return redirect()->route('equipment.index')->with('success', 'Equipment updated successfully');
    }
    
    public function destroy(string $id): RedirectResponse
    {
        // Delete equipment from database
        return redirect()->route('equipment.index')->with('success', 'Equipment deleted successfully');
    }
}