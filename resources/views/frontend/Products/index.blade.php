@extends('frontend.layout.master')
@section('title', 'Products')

@section('content')
<div class="container">
    
    <h1 class="text-center text-primary text-uppercase my-4">Product Listing</h1>

    <!-- Search Form -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for products..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary" style="background-color: grey">Clear</a>
        </div>
    </form>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="{{ route('products.show', $product->product_id) }}" class="btn">
                        <img src="{{asset('/uploads/product/'.$product->image_url)}}" class="img-fluid" style="max-width: 100%; height: 200px; object-fit: cover;" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body">         
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                        
                        <!-- Add to Cart Form with unique ID -->
                        <form action="{{ route('frontend.cart.add') }}" method="POST" class="d-flex justify-content-between align-items-center add-to-cart-form" id="add-to-cart-form-{{ $product->product_id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <button type="button" class="btn btn-success w-100 position-relative d-flex align-items-center justify-content-center add-to-cart-btn" onclick="checkLoginAndAddToCart({{ $product->product_id }})">
                                Add to Cart
                                <i class="fas fa-cart-plus ms-3" style="font-size: 18px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No products found.</p>
        @endforelse
    </div>
    
    <!-- Modal message -->
    <div id="login-message" class="modal-message">
        <div class="modal-content">
            <p>You need to log in to add items to the cart. You will be redirected to the login page.</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="redirectToLogin()">Login</button>
            </div>
        </div>
    </div>
    
    <style>
        /* Modal message styles */
        .modal-message {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Make sure it's on top */
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-content p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .modal-actions {
            margin-top: 20px;
        }

        .modal-actions .btn {
            margin: 0 10px;
        }
    </style>
    
    <script>
        function checkLoginAndAddToCart(productId) {
            @if(Auth::check())
                // If user is logged in, submit the specific form related to this product
                var form = document.getElementById('add-to-cart-form-' + productId);
                form.submit();
            @else
                // Show the modal message
                var messageBox = document.getElementById('login-message');
                messageBox.style.display = 'flex';  // Show the modal
            @endif
        }

        function closeModal() {
            var messageBox = document.getElementById('login-message');
            messageBox.style.display = 'none';  // Hide the modal
        }

        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";  // Redirect to the login page
        }
    </script>

</div>
@endsection
