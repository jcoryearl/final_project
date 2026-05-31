@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="fas fa-users"></i> User Management</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('users.create') }}" class="btn btn-info"><i class="fas fa-plus"></i> Add New User</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Users</h5>
    </div>
    <div class="card-body">
        @if(count($users) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id ?? 'N/A' }}</td>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                            <td>{{ $user->email ?? 'N/A' }}</td>
                            <td><span class="badge bg-primary">{{ $user->role ?? 'User' }}</span></td>
                            <td>{{ $user->department ?? 'N/A' }}</td>
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
                <i class="fas fa-info-circle"></i> No users found. <a href="{{ route('users.create') }}">Create one now</a>
            </div>
        @endif
    </div>
</div>
@endsection