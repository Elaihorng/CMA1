@extends('backend.layout.master')
@section('title', 'Create User')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="{{ route('index') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
        </div>
      </div>
    </section>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Create User</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('user.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="form-group col-6">
              <label for="name">FullName <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
              @error('name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group col-6">
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="row">
            <div class="form-group col-6">
              <label for="password">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" id="password">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group col-6">
              <label for="role">Role <span class="text-danger">*</span></label>
              <select name="role" class="form-control" id="role">
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
              </select>
              @error('role')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection
