@extends('layouts.app')

@section('title', 'View User')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4"><i class="fas fa-user"></i> User Details</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $user->name ?? 'User' }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Email</h6>
                        <p>{{ $user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Role</h6>
                        <p><span class="badge bg-primary">{{ $user->role ?? 'N/A' }}</span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Department</h6>
                        <p>{{ $user->department ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Phone</h6>
                        <p>{{ $user->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('users.edit', $user->id ?? '#') }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection