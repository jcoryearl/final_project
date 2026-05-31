@extends('layouts.app')

@section('title', 'Maintenance Report')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1><i class="fas fa-wrench"></i> Maintenance Report</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #3498db;">0</h3>
                <p>Total Records</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #2ecc71;">0</h3>
                <p>Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #f39c12;">0</h3>
                <p>Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 style="color: #e74c3c;">0</h3>
                <p>Overdue</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Maintenance History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Record ID</th>
                                <th>Equipment</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Technician</th>
                                <th>Duration (hours)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($maintenanceData) > 0)
                                @foreach($maintenanceData as $record)
                                <tr>
                                    <td>{{ $record->id ?? 'N/A' }}</td>
                                    <td>{{ $record->equipment_name ?? 'N/A' }}</td>
                                    <td>{{ $record->type ?? 'N/A' }}</td>
                                    <td>{{ $record->date ?? 'N/A' }}</td>
                                    <td>{{ $record->technician ?? 'N/A' }}</td>
                                    <td>{{ $record->duration ?? 'N/A' }}</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No maintenance data available</td>
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