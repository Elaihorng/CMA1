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
                            <input type="number" class="input-quantity" value="1" min="1" data-stock="{{ $product->stock_quantity }}" style="display: none;">
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
    <div id="custom-alert" class="alert-overlay">
        <div class="alert-box">
            <p id="alert-message"></p>
            <button onclick="closeAlert()">Close</button>
        </div>
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
        const form = document.getElementById('add-to-cart-form-' + productId);
        const quantity = 1;
        const productInputValue = form.querySelector('input[name="product_id"]').value;

        fetch('{{ route('frontend.cart.check-stock') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productInputValue,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Stock response:', data);
            if (data.stock_available) {
                @if(Auth::check())
                    form.submit();
                @else
                    showLoginModal();
                @endif
            } else {
                showAlert("Sorry, not enough stock available!");
            }
        })
        .catch(error => {
            console.error('Stock check failed:', error);
        });
    }

    function showAlert(message) {
        const alertBox = document.getElementById("custom-alert");
        const alertMessage = document.getElementById("alert-message");
        alertMessage.innerText = message;
        alertBox.style.display = 'flex';
    }

    function showLoginModal() {
        const messageBox = document.getElementById('login-message');
        if (messageBox) {
            messageBox.style.display = 'flex';
        }
    }

    function closeModal() {
        const messageBox = document.getElementById('login-message');
        if (messageBox) {
            messageBox.style.display = 'none';
        }
    }

    function redirectToLogin() {
        window.location.href = "{{ route('login') }}";
    }
</script>


</div>
@endsection
