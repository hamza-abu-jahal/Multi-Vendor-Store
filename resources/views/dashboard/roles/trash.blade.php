@extends('layouts.dashboard')

@section('title' , 'Trashed Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Categories</li>
    <li class="breadcrumb-item active">Trashed</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{route('dashboard.categories.index')}}" class="btn btn-outline-primary">Back</a>
</div>

 <x-alert type='success' />
 <x-alert type='info' />

 <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">

    <x-form.input name="name" placeholder="Name" :value="request('name')"/>
    <select name="status"  class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>

 </form>

  <table class="table">
    <thead>
        <tr>
            <td></td>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted At</th>
            <td colspan="2"></td>
        </tr>
    </thead>
    <tbody>
        @forelse ( $categories as $category )
        <tr>
            <td><img src="{{ asset('storage/'. $category->image) }}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name}}</td>
            <td>{{ $category->status}}</td>
            <td>{{ $category->deleted_at}}</td>
            <td>
                <form action="{{route('dashboard.categories.restore' , $category->id )}}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                 </form>
            </td>
            <td>
                 <form action="{{route('dashboard.categories.forse-delete' , $category->id )}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                 </form>
            </td>
        </tr>

        @empty
        <td>
            <td colspan="6">Empty .....</td>
        </td>
        @endforelse
    </tbody>
  </table>
  {{ $categories->withQueryString()->links() }}
  {{--{{ $categories->withQueryString()->links('pagination.custom') }} custom pagination  only file --}}

@endsection
