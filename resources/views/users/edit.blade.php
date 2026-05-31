@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-edit"></i> Edit User</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id ?? '#') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="Admin" {{ ($user->role ?? '') === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Technician" {{ ($user->role ?? '') === 'Technician' ? 'selected' : '' }}>Technician</option>
                            <option value="Manager" {{ ($user->role ?? '') === 'Manager' ? 'selected' : '' }}>Manager</option>
                            <option value="Viewer" {{ ($user->role ?? '') === 'Viewer' ? 'selected' : '' }}>Viewer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" value="{{ $user->department ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone ?? '' }}">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection