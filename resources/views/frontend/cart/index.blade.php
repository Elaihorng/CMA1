@extends('frontend.layout.master')

@section('content')
<div class="container">
    <a href="{{url('/products')}}" class="btn btn-primary py-3 px-5">Back To Proudct<i class="fa fa-arrow-left ms-3"></i></a>
    <h1 class="text-center my-4">Shopping Cart</h1>
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @if(count($cart) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Discount</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;  
            @endphp
            @foreach ($cart as $productId => $item)
                @php
                    $itemTotal = $item['price'] * (int)$item['quantity'];  
                    $discount = 0;  
                    
                    if ($item['quantity'] > 5) {
                        $discount = $itemTotal * 0.10;  
                    }
                    $itemGrandTotal = $itemTotal - $discount; 
                    $grandTotal += $itemGrandTotal;  
                @endphp
                <tr>
                    <td>
                        <img src="{{ asset('/uploads/thumbnail/product/' . ($item['image_url'] ?? 'default-image.jpg')) }}" width="50" alt="{{ $item['name'] }}">
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td>    
                        <form action="{{ route('frontend.cart.update', ['product_id' => $productId]) }}" method="POST" class="d-inline">
                            @csrf
                            <div class="input-group">
                                <button type="button" class="btn btn-update btn-sm" onclick="updateQuantity(this, -1)">-</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control input-quantity" onchange="updateQuantityFromInput(this)" readonly>
                                <button type="button" class="btn btn-update btn-sm" onclick="updateQuantity(this, 1)">+</button>
                                <button type="submit" class="btn btn-update-submit btn-sm">Update</button>
                            </div>
                        </form>
                        
                        <script>
                        function updateQuantity(button, amount) {
                            var quantityInput = button.parentElement.querySelector(".input-quantity");
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
                        
                        
                    </td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($itemTotal, 2) }}</td>
                    <td>
                        ${{ number_format($discount, 2) }} <!-- Show discount for this item -->
                    </td>
                    <td>
                        <form action="{{ route('frontend.cart.remove', ['id' => $productId]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn remove-btn d-flex align-items-center">
                                <i class="fas fa-trash-alt me-2"></i> Remove
                            </button>
                        </form>
                    
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right" style="text-align: right"><strong>Cart Total:</strong></td>
                <td colspan="2">
                    ${{ number_format($grandTotal, 2) }} <!-- Show overall Grand Total -->
                </td>
            </tr>
        </tfoot>
    </table>
    <form action="{{ route('frontend.checkout.index') }}" method="GET" class="text-end">
        @csrf   
        <button type="submit" class="btn btn-payment ">PROCED CHECKOUT</button>
    </form>
    
    
    <div class="text-right">

    </div>
    
    @else
    <p class="text-center">Your cart is empty.</p>
    @endif
</div>
@endsection