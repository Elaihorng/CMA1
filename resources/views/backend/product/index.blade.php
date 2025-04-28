@extends('backend.layout.master')
@section('title','Product')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="{{url('product/create')}}" class="btn  btn-outline-primary"><i class="fas fa-plus"></i>Create Product</a>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Product Table</h3>

                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table">
                      <thead>
                        <tr>
                          <th >#</th>
                          <th >Image</th>
                          <th>P_name</th>
                          <th >Description</th>
                          <th>price</th>
                          <th>category</th>
                          <th>S_Quantity</th>
                          <th>Progess</th>
                          <th >Label</th>
                          <th style="width: 100px;">Status</th>
                          <th style="width: 200px;">Actions</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <script>
                          // Pass the products to JavaScript in JSON format
                          var products = @json($products);
                      </script>
                      
                      @foreach($products as $key => $value)
                          <tr>
                              <td>{{ ++$key }}</td>
                              <td>
                                  <img src="{{ asset('/uploads/thumbnail/product/' . $value->image_url) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                              </td>
                              <td>{{ $value->name }}</td>
                              <td>{{ $value->description }}</td>
                              <td>{{ $value->price }}</td>
                              <td>{{ $value->category->name ?? 'No Category' }}</td>
                              <td>{{ $value->stock_quantity }}</td>
                              <td>
                                  <div class="progress progress-xs">
                                      @php
                                          $stock = $value->stock_quantity;
                                          $maxStock = 100; // Adjust this according to your max stock
                                          $percentage = ($stock / $maxStock) * 100;
                                          $progressClass = 'progress-bar-danger';
                      
                                          if ($percentage > 70) {
                                              $progressClass = 'progress-bar-success';  // Green for high stock
                                          } elseif ($percentage > 30) {
                                              $progressClass = 'progress-bar-warning';  // Yellow for medium stock
                                          }
                                      @endphp
                      
                                      <div class="progress-bar {{ $progressClass }}" style="width: {{ $percentage }}%">
                                          {{-- {{ round($percentage) }}% --}}
                                      </div>
                                  </div>
                              </td>
                              
                              <td>
                                  @php
                                      $stock = $value->stock_quantity;
                                      $maxStock = 100;
                                      $percentage = ($stock / $maxStock) * 100;
                                      
                                      // Determine badge color based on percentage
                                      if ($percentage > 70) {
                                          $badgeClass = 'bg-success';
                                      } elseif ($percentage > 30) {
                                          $badgeClass = 'bg-warning';
                                      } else {
                                          $badgeClass = 'bg-danger';
                                      }
                                  @endphp
                      
                                  <span class="badge {{ $badgeClass }}">{{ round($percentage) }}%</span>
                              </td>
                              <td>
                                @if($value->stock_quantity <= 5)
                                    <span class="badge bg-danger">Low Stock!</span>
                                @elseif($value->stock_quantity > 10)
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                            
                              <td>
                                  
                                  <a href="{{ url('product/'.$value->product_id.'/edit') }}" class="btn btn-outline-warning "><i class="fas fa-edit"></i>Edit</a>
                                  <form action="{{ url('product/'.$value->product_id) }}" method="POST" style="display: inline">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-outline-danger " onclick="confirmDelete({{ $value->product_id }})"><i class="fas fa-minus"></i>Delete</button>
                                  </form>
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
    {{-- <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  SweetAlert2 Examples
                </h3>
              </div>
              <div class="card-body">
              <button type="button" class="btn btn-success swalDefaultSuccess">
                Launch Success Toast
              </button>
              <button type="button" class="btn btn-info swalDefaultInfo">
                Launch Info Toast
              </button>
              <button type="button" class="btn btn-danger swalDefaultError">
                Launch Error Toast
              </button>
              <button type="button" class="btn btn-warning swalDefaultWarning">
                Launch Warning Toast
              </button>
              <button type="button" class="btn btn-default swalDefaultQuestion">
                Launch Question Toast
              </button>
              <div class="text-muted mt-3">
                For more examples look at <a href="https://sweetalert2.github.io/">https://sweetalert2.github.io/</a>
              </div>
              </div>
              <!-- /.card -->
            </div>
          <div>
        <div>    
      </div> 
    </section>   --}}
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