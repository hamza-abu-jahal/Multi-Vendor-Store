@extends('layouts.dashboard')

@section('title' , 'Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.roles.create')}}" class="btn btn-outline-primary mr-2">Create</a>
</div>

 <x-alert type='success' />
 <x-alert type='info' />



  <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
            <td colspan="2"></td>
        </tr>
    </thead>
    <tbody>
        @forelse ( $roles as $role )
        <tr>
            <td>{{ $role->id }}</td>
            <td><a href="{{ route('dashboard.roles.show' , $role->id) }}">{{ $role->name}}</a></td>
            <td>{{ $role->parent_name}}</td>
            <td>{{ $role->created_at}}</td>
            <td>
                @can('roles.update')
                    <a href="{{route('dashboard.roles.edit' , $role->id )}}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                @can('roles.delete')
                    <form action="{{route('dashboard.roles.destroy' , $role->id )}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                @endcan

            </td>
        </tr>

        @empty
        <tr>
            <td colspan="4">Empty .....</td>
        </tr>
        @endforelse
    </tbody>
  </table>
  {{ $roles->withQueryString()->links() }}
  {{--{{ $roles->withQueryString()->links('pagination.custom') }} custom pagination  only file --}}

@endsection
