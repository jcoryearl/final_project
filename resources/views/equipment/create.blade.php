@extends('layouts.app')

@section('title', 'Add Equipment')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-plus"></i> Add New Equipment</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Equipment Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('equipment.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Equipment Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option selected disabled>Select Type</option>
                            <option>Machinery</option>
                            <option>Electrical</option>
                            <option>HVAC</option>
                            <option>Plumbing</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('equipment.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection