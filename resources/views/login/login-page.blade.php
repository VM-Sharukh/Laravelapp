<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#f4f6f9;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-box{
            width:380px;
            background:#fff;
            padding:40px;
            border-radius:12px;
            box-shadow:0 0 20px rgba(0,0,0,0.1);
        }

        .login-box h2{
            text-align:center;
            margin-bottom:30px;
            color:#333;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group label{
            display:block;
            margin-bottom:8px;
            color:#555;
        }

        .form-control{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            outline:none;
            font-size:15px;
        }

        .form-control:focus{
            border-color:#4f46e5;
        }

        .btn-login{
            width:100%;
            padding:12px;
            background:#4f46e5;
            border:none;
            color:#fff;
            border-radius:8px;
            font-size:16px;
            cursor:pointer;
        }

        .btn-login:hover{
            background:#4338ca;
        }

        .error{
            color:red;
            font-size:14px;
            margin-top:5px;
        }

        .success-msg{
            background:#d1fae5;
            color:#065f46;
            padding:10px;
            border-radius:6px;
            margin-bottom:20px;
        }

        .error-msg{
            background:#fee2e2;
            color:#991b1b;
            padding:10px;
            border-radius:6px;
            margin-bottom:20px;
        }

    </style>

</head>
<body>

<div class="login-box">

    <h2>Login</h2>

    @if(session('success'))
        {{-- <div class="success-msg"></div> --}}

        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        {{-- <div class="error-msg"></div> --}}

        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>

    @endif

    <form action="{{ route('login.validate-user-login') }}" method="POST">

        @csrf

        <div class="form-group">
            <label>Email</label>

            <input type="text"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   placeholder="Enter email">

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Enter password">

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-login">
            Login
        </button>

    </form>

</div>

</body>
</html>