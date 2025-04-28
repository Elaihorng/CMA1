@extends('backend.layout.master')
@section('title', 'Edit User')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('index') }}" class="btn btn-outline-primary"><i class="fas fa-backward"></i> Back</a>
                </div>
            </div>
        </div>
    </section>

    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update', $user->user_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="password">New Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Leave empty to keep current password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>  
                        <div class="form-group col-6">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" id="role">
                                <option value="">Select Role</option>
                                @foreach ($roles as $roleItem)
                                    <option value="{{ $roleItem->name }}" 
                                        {{ $user->roles->contains('name', $roleItem->name) ? 'selected' : '' }}>
                                        {{ $roleItem->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Password Field -->



                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('alert_msg')
<script>
    $(function () {
        @if(session('alert_message'))
            toastr.success("{{ session('alert_message') }}");
        @endif
    });
</script>
@endsection
