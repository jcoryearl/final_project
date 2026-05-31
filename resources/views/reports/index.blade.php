@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1><i class="fas fa-chart-bar"></i> Reports</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-cogs fa-4x mb-3" style="color: #3498db;"></i>
                <h5>Equipment Report</h5>
                <p>View detailed information about all equipment in the system.</p>
                <a href="{{ route('reports.equipment') }}" class="btn btn-primary"><i class="fas fa-arrow-right"></i> View Report</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-wrench fa-4x mb-3" style="color: #2ecc71;"></i>
                <h5>Maintenance Report</h5>
                <p>View all maintenance activities and their statistics.</p>
                <a href="{{ route('reports.maintenance') }}" class="btn btn-success"><i class="fas fa-arrow-right"></i> View Report</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Report Overview</h5>
            </div>
            <div class="card-body">
                <p>Select a report from above to get started. You can generate various reports including:</p>
                <ul>
                    <li>Equipment inventory and status</li>
                    <li>Maintenance history and schedules</li>
                    <li>Technician performance</li>
                    <li>Equipment downtime analysis</li>
                    <li>Maintenance cost analysis</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection