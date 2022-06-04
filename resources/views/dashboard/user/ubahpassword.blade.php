@extends('layouts.dashboarduser')

@section('content')
  <div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Change Password</h1>
    </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if (session('errors'))
      <div class="alert alert-danger">
        {{ session('errors') }}
      </div>
    @endif

    <form method="POST" action="{{ route('user.changepassword.submit') }}">
      @csrf
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="form-row">
            <div class="name">Current Password</div>
            <div class="value">
              <input autocomplete="current-password" class="form-control" id="current_password" name="current_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password">
              <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
          </div>
          <div class="form-row">
            <div class="name">New Password</div>
            <div class="value">
              <input  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="new-password" class="form-control" id="new_password" name="new_password" type="password">
              <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
          </div>
          <div class="form-row">
            <div class="name">Confirm New Password</div>
            <div class="value">
              <input  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="new_confirm-password" class="form-control" id="new_confirm_password" type="password" name="new_confirm_password">
              <span toggle="#new_confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn--radius-2 btn--blue-2" type="submit">Change Password</button>
        </div>
      </div>
    </form>
  </div>
@endsection
@push('js')
  <script>
    function validateField() {
      if (this.value !== document.getElementById("new_password").value) {
        this.setCustomValidity('New confirm password doesn\'t match with new password!');
      } else {
        this.setCustomValidity('');
      }
    }
    window.onload = function() {
      document.getElementById("new_confirm_password").oninput = validateField;
    }
  </script>
@endpush
