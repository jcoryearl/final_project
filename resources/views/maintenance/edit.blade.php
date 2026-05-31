@extends('layouts.app')

@section('title', 'Edit Maintenance Record')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-edit"></i> Edit Maintenance Record</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Maintenance Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('maintenance.update', $maintenance->id ?? '#') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="equipment_id" class="form-label">Equipment</label>
                        <select class="form-select" id="equipment_id" name="equipment_id" required>
                            <option value="1" {{ ($maintenance->equipment_id ?? '') === '1' ? 'selected' : '' }}>Equipment 1</option>
                            <option value="2" {{ ($maintenance->equipment_id ?? '') === '2' ? 'selected' : '' }}>Equipment 2</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Maintenance Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="Preventive" {{ ($maintenance->type ?? '') === 'Preventive' ? 'selected' : '' }}>Preventive</option>
                            <option value="Corrective" {{ ($maintenance->type ?? '') === 'Corrective' ? 'selected' : '' }}>Corrective</option>
                            <option value="Predictive" {{ ($maintenance->type ?? '') === 'Predictive' ? 'selected' : '' }}>Predictive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Maintenance Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $maintenance->date ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="technician" class="form-label">Technician Name</label>
                        <input type="text" class="form-control" id="technician" name="technician" value="{{ $maintenance->technician ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $maintenance->description ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration (hours)</label>
                        <input type="number" class="form-control" id="duration" name="duration" step="0.5" value="{{ $maintenance->duration ?? '' }}">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection