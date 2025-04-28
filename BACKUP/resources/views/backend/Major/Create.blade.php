@extends('backend.layout.master')
@section('title','Create Major')
@section('content')
<div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Create Major</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{url('/major')}}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Major Type</label>
                        <input type="text" name="major_type" class="form-control" id="exampleInputEmail1" placeholder="Enter Major">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <input type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="Description">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Major Image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div>
                        </div>
                      </div>
                      {{-- <div class="form-check"> --}}
                        {{-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> --}}
                        {{-- <label class="form-check-label" for="exampleCheck1">Check me out</label> --}}
                      {{-- </div> --}}
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
    
                <!-- /.card -->
    
              </div>
              <!--/.col (left) -->
              
                <!-- /.card -->
              </div>
              <!--/.col (right) -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
</div>
@endsection
