@extends('layouts.loginforgot')

@section('content')
  <style>
    .input-icons i {
      position: absolute;
      right: 24px;
      margin-top: 2px;
    }

    .input-icons {
      width: 100%;
      margin-bottom: 10px;
    }

    .icon {
      padding: 10px;
      min-width: 50px;
      text-align: center;
    }

    .input-field {
      width: 100%;
      padding: 10px;
      text-align: start;
    }

  </style>
  <div class="card fat">
    <div class="card-body">
      <h4 class="card-title">Login</h4>
      <form action="/postlogin" method="POST" class="my-login-validation">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="username">Username</label>
          <input id="username" type="username" class="form-control" name="username" required>
          <div class="invalid-feedback">
            Username is invalid
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password
            <a href="{{ route('forget.password.get') }}">Forget Password</a>
          </label>

          <div class="input-icons">
            <i id="togglePassword" class="far fa-eye icon"></i>
            <input class="input-field form-control" type="password" id="password" name="password" required>
          </div>
          <div class="invalid-feedback">
            Password is required
          </div>
        </div>

        <br>

        <div class="form-group mt-4 mb-4">
          <div class="captcha">
            <span>{!! captcha_img('math') !!}</span>
            <button type="button" class="btn btn-danger" class="reload" id="reload">
              &#x21bb;
            </button>
          </div>
        </div>
        <div class="form-group mb-4">
          <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" required>
        </div>

        @if (session('errors'))
          <div class="alert alert-danger">
            Username, password, atau captcha mungkin salah.
          </div>
        @endif


        <div class="form-group">
          <button class="btn btn-primary btn-block" type="submit">
            LOGIN
          </button>
        </div>
      </form>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript">
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function(e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
    });

    $('#reload').click(function() {
      $.ajax({
        type: 'GET',
        url: 'reload-captcha',
        success: function(data) {
          $(".captcha span").html(data.captcha);
        }
      });
    });
  </script>
@endsection
