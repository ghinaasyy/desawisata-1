<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Desa Arborek Papua</title>

  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    body {
      background-color: #f5f5f5;
    }

    .reservation-form {
      border-radius: 10px;
      overflow: hidden;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-header {
      background: linear-gradient(135deg, #ff6b6b 0%, #f7b733 100%);
      color: white;
      padding: 20px;
      text-align: center;
    }

    .form-body {
      padding: 30px;
    }

    .form-control,
    .form-select {
      border-radius: 5px;
      padding: 10px 15px;
      border: 1px solid #ced4da;
      transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #ff6b6b;
      box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
    }

    .form-label {
      font-weight: 600;
      color: #495057;
    }

    .btn-submit {
      background: linear-gradient(135deg, #007bff 0%, #00a1ff 100%);
      border: none;
      padding: 10px 25px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .price-display {
      background-color: #f1f8ff;
      border-left: 4px solid #007bff;
      padding: 10px 15px;
      font-weight: 600;
    }

    .readonly-field {
      background-color: #e9ecef;
      cursor: not-allowed;
    }

    .body {
      background-color: rgba(179, 179, 179, 0.32);
    }

    .voucher-status {
      margin-top: 5px;
      font-size: 0.875rem;
    }

    .voucher-valid {
      color: #28a745;
    }

    .voucher-invalid {
      color: #dc3545;
    }
  </style>
</head>

<body class="body">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <nav>@include('fe.navbar')</nav>
  </header>

  @section('footer')
  @include('fe.footer')
  @endsection
</body>

</html>