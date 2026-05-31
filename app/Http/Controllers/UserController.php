<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index(): View
    {
        // Fetch all users
        $users = [];
        
        return view('users.index', ['users' => $users]);
    }
    
    public function create(): View
    {
        return view('users.create');
    }
    
    public function store(): RedirectResponse
    {
        // Store user in database
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    
    public function show(string $id): View
    {
        // Fetch single user
        return view('users.show', ['user' => []]);
    }
    
    public function edit(string $id): View
    {
        // Fetch user for editing
        return view('users.edit', ['user' => []]);
    }
    
    public function update(string $id): RedirectResponse
    {
        // Update user in database
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    
    public function destroy(string $id): RedirectResponse
    {
        // Delete user from database
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}