@extends('layouts.app')

@section('title', 'Equipment Management')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="fas fa-cogs"></i> Equipment Management</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('equipment.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Equipment</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Equipment</h5>
    </div>
    <div class="card-body">
        @if(count($equipment) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Equipment ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipment as $item)
                        <tr>
                            <td>{{ $item->id ?? 'N/A' }}</td>
                            <td>{{ $item->name ?? 'N/A' }}</td>
                            <td>{{ $item->type ?? 'N/A' }}</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>{{ $item->location ?? 'N/A' }}</td>
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
                <i class="fas fa-info-circle"></i> No equipment found. <a href="{{ route('equipment.create') }}">Create one now</a>
            </div>
        @endif
    </div>
</div>
@endsection