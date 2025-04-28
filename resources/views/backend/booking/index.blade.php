@extends('backend.layout.master')
@section('title','Inbox')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="mb-3">Inbox</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Service Booking Inbox</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>From</th>
                  <th>Email</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($booking as $key => $booking)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td><strong>{{ $booking->name }}</strong></td>
                  <td>{{ $booking->email }}</td>
                  <td>{{ \Carbon\Carbon::parse($booking->service_date)->format('d M Y') }}</td>
                  <td>
                    @if($booking->status == 'confirmed')
                      <span class="badge bg-success">Confirmed</span>
                    @else
                      <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                  </td>
                  <td>
                    @if($booking->status != 'confirmed')
                      <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                      </form>
                    @endif
                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> <!-- /.mailbox-messages -->
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
      toastr.success("{{ session('alert_messsage') }}");
    @endif  
  });
</script>
@endsection
