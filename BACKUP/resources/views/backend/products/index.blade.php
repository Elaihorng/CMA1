@extends('backend.layout.master')
@section('content')
    <h1>Manage Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">Add Product</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
    <tr>
        <td>{{ $product->product_id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->category }}</td>
        <td>
            <!-- Edit Button -->
            <a href="{{ route('admin.products.edit', ['id' => $product->product_id]) }}" class="btn btn-warning btn-sm">Edit</a>

            <!-- Delete Form -->
            <form action="{{ route('admin.products.destroy', ['id' => $product->product_id]) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
        </tbody>
    </table>
@endsection
