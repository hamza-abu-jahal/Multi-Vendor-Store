@extends('layouts.dashboard')

@section('title' , $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{$category->name}}</li>
@endsection

@section('content')

<table class="table">
    <thead>
        <tr>
            <td></td>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ( $category->products()->with('store')->get() as $product )
        <tr>
            <td><img src="{{ asset('storage/'. $product->image) }}" alt="" height="50"></td>
            <td>{{ $product->name}}</td>
            <td>{{ $product->store->name}}</td>
            <td>{{ $product->status}}</td>
            <td>{{ $product->created_at}}</td>

        </tr>

        @empty
        <td>
            <td colspan="5">Empty .....</td>
        </td>
        @endforelse
    </tbody>
  </table>

@endsection
