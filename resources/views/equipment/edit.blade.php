@extends('layouts.app')

@section('title', 'Edit Equipment')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-edit"></i> Edit Equipment</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Equipment Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('equipment.update', $equipment->id ?? '#') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $equipment->name ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Equipment Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="Machinery" {{ ($equipment->type ?? '') === 'Machinery' ? 'selected' : '' }}>Machinery</option>
                            <option value="Electrical" {{ ($equipment->type ?? '') === 'Electrical' ? 'selected' : '' }}>Electrical</option>
                            <option value="HVAC" {{ ($equipment->type ?? '') === 'HVAC' ? 'selected' : '' }}>HVAC</option>
                            <option value="Plumbing" {{ ($equipment->type ?? '') === 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                            <option value="Other" {{ ($equipment->type ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ $equipment->location ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $equipment->description ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ $equipment->purchase_date ?? '' }}">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('equipment.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection