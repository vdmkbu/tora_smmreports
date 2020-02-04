@extends('layouts.app')

@section('content')
    @include('admin._nav', ['page' => 'users'])

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mr-1">Edit</a>


        <form method="POST" action="{{ route('admin.users.switch', $user) }}" class="mr-1">
            @csrf
            @if ($user->isDisabled())
                <button class="btn btn-success">Turn on</button>
            @else
                <button class="btn btn-warning">Turn off</button>
            @endif
        </form>


        @can('manage-users')
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        @endcan
    </div>
    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th><td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($user->isDisabled())
                    <span class="badge badge-danger">Disabled</span>
                @else
                    <span class="badge badge-primary">Active</span>
                @endif

            </td>
        </tr>
        <tr>
            <th>Role</th>
            <td>
                @if ($user->isAdmin())
                    <span class="badge badge-danger">Admin</span>
                @else
                    <span class="badge badge-secondary">User</span>
                @endif
            </td>
        </tr>
        <tbody>
        </tbody>
    </table>
@endsection
