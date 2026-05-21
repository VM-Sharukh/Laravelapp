<!DOCTYPE html>
<html>
<head>
    <title>Server Error</title>
    <style>
        body{
            font-family: Arial;
            text-align:center;
            padding-top:100px;
            background:#f5f5f5;
        }
        .box{
            background:white;
            width:500px;
            margin:auto;
            padding:40px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        h1{
            color:#e74c3c;
            font-size:48px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>500</h1>
    <h2>Internal Server Error</h2>

    <p>
        Something went wrong. Please try again later.
    </p>

    <a href="{{ url('/') }}">
        Go Home
    </a>
</div>

</body>
</html>
