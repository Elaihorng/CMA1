@extends('backend.layout.master')

@section('title', 'Order Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          {{-- <div class="col-sm-6">
            <a href="{{url('product/create')}}" class="btn  btn-outline-primary"><i class="fas fa-plus"></i>Create Product</a>
          </div> --}}
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Orders Table</h3>

                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                        <a href="{{ route('orderPlace.index') }}" class="btn btn-primary py-3 px-5">Back <i class="fa fa-arrow-left ms-3"></i></a>
                        <h1 class="text-center my-4">Order Details</h1>

                        <div class="mb-3">
                            <strong>Order Number:</strong> {{ $orders->order_number }}
                        </div>
                        <div class="mb-3">
                            <strong>Total Amount:</strong> ${{ number_format($orders->total_amount, 2) }}
                        </div>
                        <div class="mb-3">
                            <strong>Delivery Method:</strong> {{ ucfirst($orders->shipping_method) }}
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong> {{ ucfirst($orders->status) }}
                        </div>
                        <div class="mb-3">
                            <strong>Payment Status:</strong> {{ ucfirst($orders->payment_status) }}
                        </div>

                        <h4>Order Items:</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders->orderItems as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('/uploads/product/'. $item->product->image_url) }}" width="50" alt="{{ $item->product->name }}">
                                        </td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
  
              <!-- /.card -->
            </div>
        </div>
      </div>
  </section>

</div>
@endsection
