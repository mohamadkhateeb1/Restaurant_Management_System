@extends('Layouts.app')
@section('title', 'Roles Management')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <x-flash_message/>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Roles List</h3>
                        <div class="card-tools">
                            <a href="{{ route('Pages.roles.create') }}" class="btn btn-primary btn-sm">Create New Role</a>
                        </div>
                    </div>
                    {{-- عرض الاخطاء --}}
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>ِ
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->abilities as $ability)
                                            {{-- عرض فقط ال allow --}}
                                            @if ($ability->type === 'allow')
                                                <span class="badge badge-info">{{ $ability->ability  }}</span>
                                            @endif
                                            @endforeach
                                        <td>
                                            <a href="{{ route('Pages.roles.edit', $role->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('Pages.roles.destroy', $role->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
