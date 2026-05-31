@extends('layouts.app')

@section('title', 'View Equipment')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-cogs"></i> Equipment Details</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $equipment->name ?? 'Equipment' }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Equipment Type</h6>
                        <p>{{ $equipment->type ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Location</h6>
                        <p>{{ $equipment->location ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Description</h6>
                    <p>{{ $equipment->description ?? 'N/A' }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Purchase Date</h6>
                        <p>{{ $equipment->purchase_date ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status</h6>
                        <p><span class="badge bg-success">Active</span></p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('equipment.edit', $equipment->id ?? '#') }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route('equipment.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection