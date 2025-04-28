@extends('backend.layout.master')
@section('title','Teacher')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="{{url('product')}}" class="btn  btn-outline-primary"><i class="fas fa-plus"></i>Back</a>
          </div>
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
          </div> --}}
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="card card-danger">
      <div class="card-header">
        <h3 class="card-title">Product Table </h3>
      </div>
      <div class="card-body">
        <form action="{{url('/product')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <!-- Date dd/mm/yyyy -->
        <div class="col-12">
          <div class="row">
            {{-- <div class="form-group col-6">
              <label for="exampleInputPassword1">Teacher Code<span class="text-danger">*</span></label>
              <input type="text" name="teacher_code" class="form-control" id="exampleInputPassword1" >
              @error('teacher_code')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div> --}}
            <div class="form-group col-6">
              <label for="exampleInputPassword1">Product Name<span class="text-danger">*</span></label>
              <input type="text" name="name" value="" class="form-control" id="exampleInputPassword1" >
              @error('name')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
            <div class="form-group col-6">
              <label for="category">Product Category<span class="text-danger">*</span></label>
              <select name="category_id" id="category" class="form-control">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)  <!-- Looping through $categories -->
                      <option value="{{ $category->id }}">{{ $category->name }}</option>  <!-- Accessing the properties of each category -->
                  @endforeach
              </select>
              @error('category_id')
                  <small class="text-danger">{{$message}}</small>
              @enderror
          </div>
          </div>

                

        </div>
        
      
        <div class="col-12">
          <div class="row">
            
            <div class="form-group col-6">
              <label for="exampleInputPassword1">Product price<span class="text-danger">*</span></label>
              <input type="text" name="price" value="" class="form-control" id="exampleInputPassword1" >
              @error('price')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
            <div class="form-group col-6">
              <label for="exampleInputPassword1">Product Stock Quantity<span class="text-danger">*</span></label>
              <input type="text" name="stock_quantity" class="form-control" id="exampleInputPassword1" >
              @error('stock_quantity')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="form-group col-12 ">
              <label>Description</label>
              <textarea class="form-control"   name="description"  rows="2" placeholder="Enter...."></textarea>
            </div>
            
          </div>
        </div>
        <!-- /.form group -->

        <!-- phone mask -->
        {{-- <div class="col-12">
          <div class="row">
            <div class="form-group col-6">
              <label>Email</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="email" name="teacher_email" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                    
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                    </div>
                </div>
                @error('teacher_email')
                      <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group col-6">
              <label>Phone</label>

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="text" name="teacher_phone" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                
              </div>
              @error('teacher_phone')
                      <small class="text-danger">{{$message}}</small>
                    @enderror
            </div>
            
          </div>
          <!-- /.input group -->
        </div> --}}
        <!-- /.form group -->

        <!-- phone mask -->
        {{-- <div class="col-12">
          <div class="row">
            <div class="form-group col-12 ">
              <label>Profile</label>
              <textarea class="form-control" name="teacher_profile" rows="2" placeholder="Enter...."> </textarea>
            </div>
            
          </div>
        </div> --}}
        <div class="col-12">
          <div class="row">
            <div class="form-group col-6">
              <label>Product Image</label>
              <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="image_url" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">choose file</label>
                </div>
                <div class="input-group-append">
                  <span class="input-group-text">Upload</span>
                </div>
              </div>
            </div>
            {{-- <div class="form-group col-6">
              <label>Display Image</label>
            </div> --}}
          </div>
        </div>
        <!-- /.form group -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <!-- /.form group -->
      </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
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
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('YYYY-MM-DD', { 'placeholder': 'YYYY-MM-DD'})
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('YYYY-MM-DD', { 'placeholder': 'YYYY-MM-DD'})
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'YYYY-MM-DD'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1" 
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
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
  function confirmDelete(majorId){
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
        axios.delete('/major/'+majorId)
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