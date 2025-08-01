@extends('frontend.layout.master')

@section('content')
<div class="container">
    <a href="{{ url('/products') }}" class="btn btn-primary py-3 px-5">Back <i class="fa fa-arrow-left ms-3"></i></a>
    
    <h1 class="text-center my-4">Product Details</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="product-gallery">
                <div class="slider">
                    <div>
                        <img src="{{ asset('/uploads/product/' . $product->image_url) }}" class="img-fluid" alt="{{ $product->name }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p><strong>Category:</strong> {{ $product->category->name ?? 'No Category' }}</p>
            <p>{{ $product->description }}</p>
            <p class="product-price">$ {{ number_format($product->price, 2) }}</p>

            <div class="d-flex mb-4">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star {{ $i <= round($product->reviews->avg('rating')) ? 'text-warning' : 'text-secondary' }}"></i>
                @endfor
                <span class="ms-2">({{ $product->reviews->count() }} Reviews)</span>
            </div>
            <form action="{{ route('frontend.cart.add') }}" method="POST" class="d-flex justify-content-between align-items-center" id="add-to-cart-form">
                @csrf
                <div class="input-group">
                    <button type="button" class="btn btn-update btn-sm" onclick="updateQuantity(this, -1)">-</button>
                    <input type="number" name="quantity" id="quantity-input" value="1" min="1" class="form-control input-quantity" onchange="updateQuantityFromInput(this)" data-stock="{{ $product->stock_quantity }}">
                    <button type="button" class="btn btn-update btn-sm" onclick="updateQuantity(this, 1)">+</button>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <button type="button" class="btn btn-success w-100 position-relative d-flex align-items-center justify-content-center add-to-cart-btn" onclick="checkLoginAndAddToCart()">
                    Add to Cart
                    <i class="fas fa-cart-plus ms-3" style="font-size: 18px;"></i>
                </button>
            </form>
            
            
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
            <div id="custom-alert" class="alert-overlay">
                <div class="alert-box">
                    <p id="alert-message"></p>
                    <button onclick="closeAlert()">Close</button>
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
                function checkLoginAndAddToCart() {
                    const form = document.getElementById('add-to-cart-form');
                    const quantity = parseInt(document.getElementById('quantity-input').value);
                    const productId = form.querySelector('input[name="product_id"]').value;

                    // Check stock via AJAX
                    fetch('{{ route('frontend.cart.check-stock') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
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
                    var alertBox = document.getElementById("custom-alert");
                    var alertMessage = document.getElementById("alert-message");
                    alertMessage.innerText = message;
                    alertBox.style.display = 'flex';
                }

                function closeAlert() {
                    var alertBox = document.getElementById("custom-alert");
                    alertBox.style.display = 'none';
                }

                function updateQuantity(button, amount) {
                    var quantityInput = button.parentElement.querySelector(".input-quantity");
                    var currentQuantity = parseInt(quantityInput.value);
                    var stockQuantity = parseInt(quantityInput.getAttribute("data-stock")); // Get stock quantity from data-stock

                    var newQuantity = currentQuantity + amount;

                    // Check if new quantity exceeds stock quantity
                    if (newQuantity > stockQuantity) {
                        showAlert("Sorry, not enough stock!");
                        return;
                    }

                    // Update the quantity if it's valid
                    if (newQuantity >= 1) {
                        quantityInput.value = newQuantity;
                    }
                }

                function updateQuantityFromInput(input) {
                    var currentQuantity = parseInt(input.value);
                    var stockQuantity = parseInt(input.getAttribute("data-stock"));

                    if (currentQuantity < 1) {
                        input.value = 1;
                    } else if (currentQuantity > stockQuantity) {
                        showAlert("Sorry, not enough stock!");
                        input.value = stockQuantity; // Reset to max available stock
                    }
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
    </div>

    {{-- Reviews --}}
    <hr>
    <div class="my-5">
        <h3>Customer Reviews</h3>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        {{-- Existing Reviews --}}
        @forelse($reviews as $review)
            <div class="border p-3 my-3 rounded">
                @if(Auth::check())
                    <strong>{{ Auth::user()->name }}</strong>
                @else
                    <strong>Guest</strong>
                @endif
                <div>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                </div>
                <p class="mt-2">{{ $review->review_text }}</p>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p>No reviews yet. Be the first to review this product!</p>
        @endforelse

    </div>

    {{-- Add a Review --}}
    @auth
    <div class="my-5">
        <h4>Write a Review</h4>
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                    <option value="">Select rating</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label for="review_text" class="form-label">Review</label>
                <textarea name="review_text" rows="4" class="form-control" placeholder="Write your review here..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
    @else
        <p><a href="{{ route('login') }}">Login</a> to write a review.</p>
    @endauth
</div>
@endsection

{{-- Slider Script --}}
<script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });

    function updateQuantity(amount) {
        var quantityInput = document.getElementById('quantity-input');
        var currentQuantity = parseInt(quantityInput.value);
        var newQuantity = currentQuantity + amount;

        if (newQuantity >= 1) {
            quantityInput.value = newQuantity;
        }
    }

    function updateQuantityFromInput(input) {
        var currentQuantity = parseInt(input.value);
        if (currentQuantity < 1) {
            input.value = 1;
        }
    }
</script>
