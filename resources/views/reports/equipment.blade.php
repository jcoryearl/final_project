@extends('layouts.app')

@section('title', 'Equipment Report')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1><i class="fas fa-cogs"></i> Equipment Report</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #3498db;">0</h3>
                <p>Total Equipment</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #2ecc71;">0</h3>
                <p>Active Equipment</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #f39c12;">0</h3>
                <p>Inactive Equipment</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #e74c3c;">0</h3>
                <p>Under Maintenance</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Equipment Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Equipment ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Last Maintenance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($equipmentData) > 0)
                                @foreach($equipmentData as $item)
                                <tr>
                                    <td>{{ $item->id ?? 'N/A' }}</td>
                                    <td>{{ $item->name ?? 'N/A' }}</td>
                                    <td>{{ $item->type ?? 'N/A' }}</td>
                                    <td>{{ $item->location ?? 'N/A' }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>{{ $item->last_maintenance ?? 'Never' }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No equipment data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Reports</a>
    </div>
</div>
@endsection