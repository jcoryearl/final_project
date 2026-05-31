@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="mb-4"><i class="fas fa-home"></i> Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h3>{{ $totalEquipment }}</h3>
                <p>Total Equipment</p>
                <i class="fas fa-cogs fa-2x" style="color: #3498db;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h3>{{ $totalMaintenance }}</h3>
                <p>Total Maintenance Records</p>
                <i class="fas fa-wrench fa-2x" style="color: #2ecc71;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h3>{{ $pendingMaintenance }}</h3>
                <p>Pending Maintenance</p>
                <i class="fas fa-hourglass-half fa-2x" style="color: #f39c12;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h3>{{ $completedMaintenance }}</h3>
                <p>Completed Maintenance</p>
                <i class="fas fa-check-circle fa-2x" style="color: #27ae60;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('equipment.create') }}" class="btn btn-primary me-2"><i class="fas fa-plus"></i> Add Equipment</a>
                <a href="{{ route('maintenance.create') }}" class="btn btn-success me-2"><i class="fas fa-plus"></i> Create Maintenance Record</a>
                <a href="{{ route('users.create') }}" class="btn btn-info me-2"><i class="fas fa-plus"></i> Add User</a>
                <a href="{{ route('reports.index') }}" class="btn btn-warning"><i class="fas fa-chart-bar"></i> View Reports</a>
            </div>
        </div>
    </div>
</div>
@endsection