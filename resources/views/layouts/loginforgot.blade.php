<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title }}</title>

  <link href="{{ asset('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css') }}" rel="stylesheet"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link rel="icon" type="image/png" href="img/logo 2.png">
</head>

<body class="login-page">
  <div class="container-fluid mx-auto">
    <div class="row justify-content-md-center">
      <div class="card-wrapper">
        <div class="brand">
          <img src="img/logo 2.png" alt="logo">
        </div>
        @yield('content')
      </div>
    </div>
  </div>
</body>

</html>
