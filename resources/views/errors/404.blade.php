<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403-page</title>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <style>
        body {
            background-color: #1c2127;
        }
        .container{
            width: 500px;
            height: 500px;
            position: relative;
        }
        .image{
            width: 100%;
            height: 100%;
            position: absolute;
            left: 200px;
        }
        .message {
            font-family: "Poppins", sans-serif;
            font-size: 30px;
            color: white;
            font-weight: 500;
            position: absolute;
            right: 300px;
            bottom: 280px;

        }
        .message2 {
            font-family: "Poppins", sans-serif;
            font-size: 23px;
            color: white;
            font-weight: 300;
            width: 360px;
            position: absolute;
            right: 207px;
            bottom: 250px;
        }
        a{
            text-decoration: none;
            color: #10b981;
            transition: all 300ms;
        }
        a:hover{
            color: #6ed6b1;
        }
        .neon {
            cursor: default;
            text-align: center;
            width: 300px;
            margin-top: 30px;
            margin-bottom: 10px;
            font-family: "Varela Round", sans-serif;
            font-size: 90px;
            color: #10b981;
            letter-spacing: 3px;
            text-shadow: 0 0 5px #6eecc1;
            animation: flux 2s linear infinite;
            position: absolute;
            right: 292px;
            bottom: 310px;
        }
        @keyframes flux {
            0%,
            100% {
                text-shadow: 0 0 5px #00ffc6, 0 0 15px #00ffc6, 0 0 50px #00ffc6,
                0 0 50px #00ffc6, 0 0 2px #b9ffe8, 2px 2px 3px #12e29c;
                color: #4bffef;
            }
            50% {
                text-shadow: 0 0 3px #00b58d, 0 0 7px #00b58d, 0 0 25px #00b58d,
                0 0 25px #00b58d, 0 0 2px #00b58d, 2px 2px 3px #006a60;
                color: #63d3ae;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <img src="{{asset('images/404.png')}}" class="image" alt="">
</div>
<div class="neon">404</div>
<div class="message">Page Not Found...!
</div>
<div class="message2">Get back to your Home</div>
</body>
</html>
