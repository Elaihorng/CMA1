@extends('backend.layout.master')
@section('title','Stock Management')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Header if needed --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Stock Management</h3>
                  </div>
                  <div class="card-header d-flex justify-content-between align-items-center">

                    <a href="{{ route('stock.history') }}" class="btn btn-primary btn-sm">View Stock History</a>
                </div>
                
                  <div class="card-body p-0">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="width: 30px;">#</th>
                          <th>Product Name</th>
                          <th>Stock In / Out</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $key => $product)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <form action="{{ route('stock.in') }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="number" name="quantity" min="1" placeholder="Stock In Qty" required>
                                    <input type="text" name="note" placeholder="Optional Note">
                                    <button type="submit" class="btn btn-success btn-sm">Stock In</button>
                                </form>

                                <form action="{{ route('stock.out') }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="number" name="quantity" min="1" placeholder="Stock Out Qty" required>
                                    <input type="text" name="note" placeholder="Optional Note">
                                    <button type="submit" class="btn btn-danger btn-sm">Stock Out</button>
                                    @section('alert_msg')
                                    <script>
                                      $(function() {
                                        @if(session('success'))
                                          toastr.success("{{ session('success') }}");
                                        @endif

                                        @if(session('error'))
                                          toastr.error("{{ session('error') }}");
                                        @endif
                                      });
                                    </script>
                                    @endsection

                                </form>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </section>
</div>

@endsection

@section('alert_msg')
<script>
  $(function() {
    @if(session('alert_messsage'))
      toastr.success("{{session('alert_messsage')}}");
    @endif
  });
</script>
@endsection
