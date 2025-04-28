@extends('frontend.layout.master')
@section('content')
    <div class="container my-5">
        <div class="row">

            <!-- Billing Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Billing Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name (Optional)</label>
                                <input type="text" id="company_name" name="company_name" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" name="address" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country / Region</label>
                                    <select id="country" name="country" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Cambodia">Cambodia</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <select id="state" name="state" class="form-select">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="order_notes" class="form-label">Additional Info</label>
                                <textarea id="order_notes" name="order_notes" rows="3" class="form-control" placeholder="Order Notes"></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" id="ship_default" name="ship_default" class="form-check-input">
                                <label for="ship_default" class="form-check-label">Ship to Default Address</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="self_pickup" name="self_pickup" class="form-check-input">
                                <label for="self_pickup" class="form-check-label">Self Pick Up</label>
                            </div>
                        </form>
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
                                <tr>
                                    <td>Acer Aspire 3 A315-24P</td>
                                    <td class="text-center">2</td>
                                    <td class="text-end">$718.00</td>
                                </tr>
                                <tr>
                                    <td>Ram Laptop Adapter</td>
                                    <td class="text-center">1</td>
                                    <td class="text-end">$49.00</td>
                                </tr>
                                <tr>
                                    <td>Logitech MX370 Case</td>
                                    <td class="text-center">1</td>
                                    <td class="text-end">$40.00</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">SUB-TOTAL:</p>
                            <p class="mb-0">$807.00</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">SHIPPING FEE:</p>
                            <p class="mb-0">Free</p>
                        </div>
                        <div class="d-flex justify-content-between fw-bold mt-2">
                            <p class="mb-0">TOTAL:</p>
                            <p class="mb-0">$887.00</p>
                        </div>
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="#" class="btn btn-secondary">Back to Cart</a>
                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection