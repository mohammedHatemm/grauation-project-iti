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
            right: 250px;
            bottom: 280px;

        }
        .message2 {
            font-family: "Poppins", sans-serif;
            font-size: 23px;
            color: white;
            font-weight: 300;
            width: 360px;
            position: absolute;
            right: 140px;
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
<img src="{{asset('images/403.png')}}" class="image" alt="">
</div>
    <div class="neon">403</div>
<div class="message">You are not authorized...!
</div>
@if(auth()->user()->role === 'merchant')
<div class="message2">Go <a href="{{route('conclusion')}}"> Home!</a></div>
@endif
@if(auth()->user()->role === 'employee')
    <div class="message2">Go <a href="{{route('employee.orders.empdash')}}"> Home!</a></div>
@endif
@if(auth()->user()->role === 'delivery_man')
    <div class="message2">Go <a href="{{route('orders.delidash')}}"> Home!</a></div>
@endif
</body>
</html>



{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <title>Document</title>--}}
{{--    <head>--}}
{{--        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">--}}
{{--        <style>--}}
{{--            body {--}}
{{--                background-color: #1c2127;--}}
{{--            }--}}
{{--            .container {--}}
{{--                position: absolute;--}}
{{--                left: 400px;--}}
{{--            }--}}
{{--            .message {--}}
{{--                font-family: "Poppins", sans-serif;--}}
{{--                font-size: 30px;--}}
{{--                color: white;--}}
{{--                font-weight: 500;--}}
{{--                position: absolute;--}}
{{--                top: 330px;--}}
{{--                right: 250px;--}}
{{--            }--}}
{{--            .message2 {--}}
{{--                font-family: "Poppins", sans-serif;--}}
{{--                font-size: 20px;--}}
{{--                color: white;--}}
{{--                font-weight: 300;--}}
{{--                width: 360px;--}}
{{--                position: absolute;--}}
{{--                top: 370px;--}}
{{--                right: 125px;--}}
{{--            }--}}

{{--            a{--}}
{{--                text-decoration: none;--}}
{{--                color: #10b981;--}}
{{--                transition: all 300ms;--}}
{{--            }--}}

{{--            a:hover{--}}
{{--                color: #6ed6b1;--}}
{{--            }--}}

{{--            .neon {--}}
{{--                text-align: center;--}}
{{--                width: 300px;--}}
{{--                margin-top: 30px;--}}
{{--                margin-bottom: 10px;--}}
{{--                font-family: "Varela Round", sans-serif;--}}
{{--                font-size: 90px;--}}
{{--                color: #10b981;--}}
{{--                letter-spacing: 3px;--}}
{{--                text-shadow: 0 0 5px #6eecc1;--}}
{{--                animation: flux 2s linear infinite;--}}
{{--            }--}}
{{--            .trash {--}}
{{--                width: 170px;--}}
{{--                height: 220px;--}}
{{--                background-color: #585f67;--}}
{{--                top: 300px;--}}
{{--            }--}}
{{--            .can {--}}
{{--                width: 190px;--}}
{{--                height: 30px;--}}
{{--                background-color: #6b737c;--}}
{{--                border-radius: 15px 15px 0 0;--}}
{{--            }--}}
{{--            .door-frame {--}}
{{--                height: 495px;--}}
{{--                width: 295px;--}}
{{--                border-radius: 90px 90px 0 0;--}}
{{--                background-color: #8594a5;--}}
{{--                display: flex;--}}
{{--                justify-content: center;--}}
{{--                align-items: center;--}}
{{--            }--}}

{{--            .door {--}}
{{--                height: 450px;--}}
{{--                width: 250px;--}}
{{--                border-radius: 70px 70px 0 0;--}}
{{--                background-color: #a0aec0;--}}
{{--            }--}}

{{--            .eye {--}}
{{--                top: 15px;--}}
{{--                left: 25px;--}}
{{--                height: 5px;--}}
{{--                width: 15px;--}}
{{--                border-radius: 50%;--}}
{{--                background-color: white;--}}
{{--                animation: eye 7s ease-in-out infinite;--}}
{{--                position: absolute;--}}
{{--            }--}}
{{--            .eye2 {--}}
{{--                left: 65px;--}}
{{--            }--}}

{{--            .window {--}}
{{--                height: 40px;--}}
{{--                width: 130px;--}}
{{--                background-color: #1c2127;--}}
{{--                border-radius: 3px;--}}
{{--                margin: 80px auto;--}}
{{--                position: relative;--}}
{{--            }--}}

{{--            .leaf {--}}
{{--                height: 40px;--}}
{{--                width: 130px;--}}
{{--                background-color: #8594a5;--}}
{{--                border-radius: 3px;--}}
{{--                margin: 80px auto;--}}
{{--                animation: leaf 7s infinite;--}}
{{--                transform-origin: right;--}}
{{--            }--}}

{{--            .handle {--}}
{{--                height: 8px;--}}
{{--                width: 50px;--}}
{{--                border-radius: 4px;--}}
{{--                background-color: #ebf3fc;--}}
{{--                position: absolute;--}}
{{--                margin-top: 250px;--}}
{{--                margin-left: 30px;--}}
{{--            }--}}

{{--            .rectangle {--}}
{{--                height: 70px;--}}
{{--                width: 25px;--}}
{{--                background-color: #cbd8e6;--}}
{{--                border-radius: 4px;--}}
{{--                position: absolute;--}}
{{--                margin-top: 220px;--}}
{{--                margin-left: 20px;--}}
{{--            }--}}

{{--            @keyframes leaf {--}}
{{--                0% {--}}
{{--                    transform: scaleX(1);--}}
{{--                }--}}
{{--                5% {--}}
{{--                    transform: scaleX(0.2);--}}
{{--                }--}}
{{--                70% {--}}
{{--                    transform: scaleX(0.2);--}}
{{--                }--}}
{{--                75% {--}}
{{--                    transform: scaleX(1);--}}
{{--                }--}}
{{--                100% {--}}
{{--                    transform: scaleX(1);--}}
{{--                }--}}
{{--            }--}}

{{--            @keyframes eye {--}}
{{--                0% {--}}
{{--                    opacity: 0;--}}
{{--                    transform: translateX(0);--}}
{{--                }--}}
{{--                5% {--}}
{{--                    opacity: 0;--}}
{{--                }--}}
{{--                15% {--}}
{{--                    opacity: 1;--}}
{{--                    transform: translateX(0);--}}
{{--                }--}}
{{--                20% {--}}
{{--                    transform: translateX(15px);--}}
{{--            }--}}
{{--                35% {--}}
{{--                    transform: translateX(15px);--}}
{{--            }--}}
{{--                40% {--}}
{{--                    transform: translateX(-15px);--}}
{{--            }--}}
{{--                60% {--}}
{{--                    transform: translateX(-15px);--}}
{{--            }--}}
{{--                65% {--}}
{{--                    transform: translateX(0);--}}
{{--                }--}}
{{--            }--}}

{{--            @keyframes flux {--}}
{{--                0%,--}}
{{--                100% {--}}
{{--                    text-shadow: 0 0 5px #00ffc6, 0 0 15px #00ffc6, 0 0 50px #00ffc6,--}}
{{--                    0 0 50px #00ffc6, 0 0 2px #b9ffe8, 2px 2px 3px #12e29c;--}}
{{--                color: #4bffef;--}}
{{--            }--}}
{{--                50% {--}}
{{--                    text-shadow: 0 0 3px #00b58d, 0 0 7px #00b58d, 0 0 25px #00b58d,--}}
{{--                    0 0 25px #00b58d, 0 0 2px #00b58d, 2px 2px 3px #006a60;--}}
{{--                color: #63d3ae;--}}
{{--            }--}}
{{--            }--}}

{{--        </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="message">You are not authorized...!--}}
{{--</div>--}}
{{--<div class="message2">Go <a href="{{route('dashboard')}}"> Home!</a></div>--}}
{{--<div class="container">--}}
{{--    <div class="neon">403</div>--}}
{{--    <div class="door-frame">--}}
{{--        <div class="door">--}}
{{--            <div class="rectangle">--}}
{{--            </div>--}}
{{--            <div class="handle">--}}
{{--            </div>--}}
{{--            <div class="window">--}}
{{--                <div class="eye">--}}
{{--                </div>--}}
{{--                <div class="eye eye2">--}}
{{--                </div>--}}
{{--                <div class="leaf">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}
