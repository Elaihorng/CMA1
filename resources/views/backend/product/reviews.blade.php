@extends('backend.layout.master') <!-- Assuming you have a master layout for the admin panel -->

@section('content')
    <div class="container">
        <h1>Reviews for Product: {{ $product->name }}</h1>

        <div class="my-5">
            <h3>Customer Reviews</h3>
            @forelse($reviews as $review)
                <div class="border p-3 my-3 rounded">
                    <strong>{{ $review->user->name }}</strong>
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                    </div>
                    <p class="mt-2">{{ $review->review_text }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p>No reviews yet for this product.</p>
            @endforelse
        </div>
    </div>
@endsection
