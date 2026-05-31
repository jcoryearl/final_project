@extends('layouts.app')

@section('title', 'Maintenance Records')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="fas fa-wrench"></i> Maintenance Records</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('maintenance.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> New Record</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Maintenance Records</h5>
    </div>
    <div class="card-body">
        @if(count($maintenanceRecords) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Record ID</th>
                            <th>Equipment</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Technician</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenanceRecords as $record)
                        <tr>
                            <td>{{ $record->id ?? 'N/A' }}</td>
                            <td>{{ $record->equipment_name ?? 'N/A' }}</td>
                            <td>{{ $record->type ?? 'N/A' }}</td>
                            <td>{{ $record->date ?? 'N/A' }}</td>
                            <td>{{ $record->technician ?? 'N/A' }}</td>
                            <td><span class="badge bg-info">Completed</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle"></i> No maintenance records found. <a href="{{ route('maintenance.create') }}">Create one now</a>
            </div>
        @endif
    </div>
</div>
@endsection