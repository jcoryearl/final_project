@extends('layouts.app')

@section('title', 'View Maintenance Record')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-wrench"></i> Maintenance Record</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Record Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Equipment</h6>
                        <p>{{ $maintenance->equipment_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Maintenance Type</h6>
                        <p>{{ $maintenance->type ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Date</h6>
                        <p>{{ $maintenance->date ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Technician</h6>
                        <p>{{ $maintenance->technician ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Description</h6>
                    <p>{{ $maintenance->description ?? 'N/A' }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Duration (hours)</h6>
                        <p>{{ $maintenance->duration ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status</h6>
                        <p><span class="badge bg-success">Completed</span></p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('maintenance.edit', $maintenance->id ?? '#') }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route('maintenance.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection