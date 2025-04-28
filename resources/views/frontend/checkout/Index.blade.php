@extends('frontend.layout.master')
@section('content')
<form action="{{ route('frontend.checkout.process') }}" method="POST" id="payment-form">
    @csrf
    <div class="container my-5">
        <div class="row">

            <!-- Billing Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Billing Information</h5>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="shipping_address" rows="2" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="order_notes" class="form-label">Additional Info</label>
                            <textarea id="order_notes" name="order_notes" rows="3" class="form-control" placeholder="Order Notes"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $product_id => $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-end">${{ $item['price'] * $item['quantity'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">SUB-TOTAL:</p>
                            <p class="mb-0">${{ $total }}</p>
                        </div>

                        <h5 class="mt-3">Delivery Method</h5>
                        <div class="mb-3">
                            <input type="radio" id="pickup" name="shipping_method" value="pickup" checked>
                            <label for="pickup">Pickup at store (Free)</label><br>
                            <input type="radio" id="shipping" name="shipping_method" value="shipping">
                            <label for="shipping">Shipping (+$5)</label>
                        </div>
                        <h5 class="mt-3">Payment Method</h5>
                        <div class="mb-3">
                            <input type="radio" id="visa" name="payment_method" value="STRIPE">
                            <label for="visa">Pay with Visa (ABA)</label><br>
                            <input type="radio" id="cash" name="payment_method" value="CASH"checked>
                            <label for="cash">Pay with Cash</label>
                        </div>
                        <div id="stripe-payment" style="display: none;">
                            <div class="mb-3">
                                <label for="card-element">Card Details</label>
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" class="text-danger mt-2"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">SHIPPING FEE:</p>
                            <p class="mb-0" id="shipping-fee-display">$0</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="mb-0"><strong>Grand Total:</strong></p>
                            <p class="mb-0"><strong id="grand-total">${{ $total }}</strong></p>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="shipping_fee" id="shipping_fee" value="0">
                        <input type="hidden" name="grand_total" id="grand_total_input" value="{{ $total }}">

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ url('/cart') }}" class="btn btn-secondary">Back to Cart</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary">Place Order</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stripe = Stripe('pk_test_51RG2tPC0qOc2C6aBP7sllxeaefJSciMscCE7o5CNc1DpXJ2c8UpBQsmRqw7byouMdUKdZrLt0gtgWtxpvIm4aciJ002KGdjAJR'); // Replace with your actual Stripe public key
        const clientSecret = 'client_secret_from_response'; 
        const elements = stripe.elements();
        const card = elements.create('card');
        const cardElement = document.getElementById('card-element');
        const paymentForm = document.getElementById('payment-form');
        const paymentMethodRadio = document.getElementsByName('payment_method');

        // Hide Stripe payment form by default
        const stripePaymentSection = document.getElementById('stripe-payment');
        const submitButton = document.getElementById('submit-btn');

        // Show Stripe form only when ABA_CARD is selected
        paymentMethodRadio.forEach(radio => {
            radio.addEventListener('change', function () {
                if (document.getElementById('visa').checked) {
                    stripePaymentSection.style.display = 'block';
                } else {
                    stripePaymentSection.style.display = 'none';
                }
            });
        });

        // Mount the card element
        card.mount(cardElement);
        paymentForm.addEventListener('submit', function (event) {
            event.preventDefault();
            console.log('Form is being submitted'); // Debugging line

            // Disable the submit button
            submitButton.disabled = true;

            // Handle STRIPE payment
            if (document.getElementById('visa').checked) {
                stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                }).then(function(result) {
                    console.log(result);
                    if (result.error) {
                        document.getElementById('card-errors').textContent = result.error.message;
                        submitButton.disabled = false;
                    } else {
                        const formData = new FormData(paymentForm);
                        formData.append('payment_method_id', result.paymentMethod.id);

                        fetch('/checkout/process', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            const clientSecret = data.clientSecret; // From your server
                            stripe.confirmCardPayment(clientSecret, {
                                payment_method: {
                                    card: card,
                                    billing_details: {
                                        name: document.getElementById('first_name').value + " " + document.getElementById('last_name').value,
                                        email: document.getElementById('email').value,
                                        phone: document.getElementById('phone').value
                                    }
                                }
                            }).then(function(result) {
                                if (result.error) {
                                    document.getElementById('card-errors').textContent = result.error.message;
                                } else {
                                    if (result.paymentIntent.status === 'succeeded') {
                                        // Redirect to success page
                                        window.location.href = "/checkout/success";
                                    }
                                }
                            });
                        });

                    }
                });
            } else {
                // If cash payment, just submit the form
                paymentForm.submit();
            }
        });
        

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pickupRadio = document.getElementById('pickup');
        const shippingRadio = document.getElementById('shipping');
        const shippingFeeDisplay = document.getElementById('shipping-fee-display');
        const grandTotalDisplay = document.getElementById('grand-total');
        const shippingFeeInput = document.getElementById('shipping_fee');
        const grandTotalInput = document.getElementById('grand_total_input');

        const baseTotal = {{ $total }};

        function updateTotals() {
            let fee = 0;

            if (pickupRadio.checked) {
                fee = 0;
                shippingFeeDisplay.innerText = "Free";
            } else {
                fee = 5;
                shippingFeeDisplay.innerText = "$5";
            }

            const finalTotal = baseTotal + fee;

            grandTotalDisplay.innerText = "$" + finalTotal;
            shippingFeeInput.value = fee;
            grandTotalInput.value = finalTotal;
        }

        pickupRadio.addEventListener('change', updateTotals);
        shippingRadio.addEventListener('change', updateTotals);

        updateTotals(); // Run once on page load
    });


</script>
