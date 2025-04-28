@extends('backend.layout.master')
@section('title','User List')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{url('user/create')}}" class="btn  btn-outline-primary"><i class="fas fa-plus"></i>Create User</a>
                    <h4>All Users</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">User Table</h3>
                </div>

                <div class="card-body p-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="width: 200px;">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $i => $user)
                      <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                          <img src="{{asset('backend/dist/img/avatar4.png')}}"  alt="Avatar" class="img-size-50 mr-3 img-circle">
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->first()->name ?? 'No Role' }}</td>
                        <td>
                          @if($user->otp_verified_at)
                            <span class="badge bg-success">Verified</span>
                          @else
                            <span class="badge bg-danger">Unverified</span>
                          @endif
                        </td>
                        <td>
                          <a href="{{ url('user/'.$user->user_id.'/edit') }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i> Edit</a>
                          <form method="POST" action="{{ url('user/'.$user->user_id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $user->user_id }})"><i class="fas fa-trash"></i> Delete</button>
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
  function confirmDelete(userId){
    Swal.fire({
      title: "Are you sure?",
      text: "This user will be deleted permanently!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete!"
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete('/user/' + userId)
        .then(response => {
          Swal.fire({
            title: "Deleted!",
            text: "User has been deleted.",
            icon: "success"
          });
          setTimeout(() => {
            location.reload();
          }, 2000);
        }).catch(error => {
          Swal.fire("Error", "Something went wrong!", "error");
        });
      }
    });
  }
</script>
@endsection
