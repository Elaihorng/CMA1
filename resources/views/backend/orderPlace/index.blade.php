@extends('backend.layout.master')
@section('title','orders_Place')
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
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="width: 30px;">#</th>
                          <th style="width: 120px;">Order Number</th>
                          <th style="width: 120px;">Item</th>
                          <th style="width: 120px;">Total Amount</th>
                          <th style="width: 120px;">D_Method</th>
                          <th style="width: 60px;">Status</th>
                          <th style="width: 120px;">Payment Status</th>
                          <th style="width: 120px;">Order Date</th>
                          <th style="width: 200px;">Actions</th>
                        </tr>
                        
                      </thead>
                      <tbody>
                        <script>
                          // Pass the products to JavaScript in JSON format
                          var orders = @json($orders);
                      </script>
                      
                      @foreach($orders  as $key => $order)
                          <tr>
                              <td>{{ ++$key }}</td>
                              <td>{{ $order->order_number }}</td>
                              <td>
                                  @foreach ($order->orderItems as $item)
                                      {{ $item->product->name }}@if (!$loop->last), @endif
                                  @endforeach
                              </td>
                              <!-- Total Amount -->
                              <td>${{ number_format($order->total_amount, 2) }}</td>
              
                              <!-- Delivery Method (Shipping Method) -->
                              <td>{{ ucfirst($order->shipping_method) }}</td>
              
                              <!-- Order Status -->
                              <td>{{ ucfirst($order->status) }}</td>
              
                              <!-- Payment Status -->
                              <td>{{ ucfirst($order->payment_status) }}</td>
              
                              <!-- Order Date -->
                              <td>{{ $order->order_date->format('Y-m-d H:i:s') }}</td>
              
                              <!-- Actions (e.g., View, Cancel, etc.) -->
                              <td>
                                <a href="{{ route('backend.orderPlace.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                            
                                @if($order->status !== 'confirmed' && $order->status !== 'cancelled')
                                    <form action="{{ route('backend.orderPlace.cancel', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                    </form>
                            
                                    <form action="{{ route('backend.orderPlace.confirm', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                    </form>
                                @elseif($order->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            
                                @if($order->payment_method === 'CASH' && $order->payment_status !== 'paid')
                                    <form action="{{ route('backend.orders.markAsPaid', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Mark as Paid</button>
                                    </form>
                                @endif
                            </td>
                            
                            
                            
                             
                              
                          </tr>
                      @endforeach
                      
                      <script>
                          // JavaScript to alert when stock is below 5
                          products.forEach(function(product) {
                              if (product.stock_quantity < 5) {
                                  alert('Warning: Stock for product ' + product.name + ' is low! Only ' + product.stock_quantity + ' left.');
                              }
                          });
                      </script>
                      

                      </tbody> 
                    </table>
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
@section('alert_msg')
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    @if(session('alert_messsage'))
      toastr.success("{{session('alert_messsage')}}");
    @endif  
    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
  });
  function confirmDelete(productId){
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete('/product/'+productId)
        .then(response=>{
          Swal.fire({
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success"
        });
        setTimeout(() => {
          location.reload();
        }, 3000);
        
        })
      }
    });
  }
</script>
@endsection