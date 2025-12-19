@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Admins List</h1>
                <a href="{{ route('Pages.admin.create') }}" class="btn btn-primary mb-3">Create New Admin</a>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @foreach ($admin->roles as $role)
                                        <span class="badge bg-secondary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- زر العرض --}}
                                        <a href="{{ route('Pages.admin.show', $admin->id) }}" class="btn btn-sm btn-outline-info mr-1" title="Show">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- زر التعديل --}}
                                        <a href="{{ route('Pages.admin.edit', $admin->id) }}" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- زر الحذف --}}
                                        <form action="{{ route('Pages.admin.destroy', $admin->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection