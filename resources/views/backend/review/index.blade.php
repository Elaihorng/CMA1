@extends('backend.layout.master')
@section('title','Product Reviews')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Product Reviews</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Reviews</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product_id</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $key => $review)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $review->product->product_id }}</td>
                            <td>{{ $review->product->name }}</td>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ $review->rating }} ⭐</td>
                            <td>{{ $review->review_text }}</td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
