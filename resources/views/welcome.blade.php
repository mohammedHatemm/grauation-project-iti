<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saree3 - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Aclonica&family=Aubrey&family=Birthstone&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Lexend+Deca:wght@100..900&family=Merienda:wght@300..900&family=Micro+5&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Playwrite+IE+Guides&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Silkscreen:wght@400;700&family=Tiny5&display=swap"
        rel="stylesheet">
</head>
<body class="bg-[#18181b] text-white flex flex-col items-center justify-center min-h-screen">
<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center justify-center md:text-left mt-20">
        <div class="md:col-span-3 flex justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Saree3 Logo" class="w-auto h-40 md:h-52 animate-bounceSlow">
        </div>
        <div class="md:col-span-3">
            <!-- Slogan -->
            <h1 class="text-2xl font-semibold mt-4 text-center text-[#10b981] animate-fadeIn delay-200">
                Slow is Just Our Logo, Fast is Our Promise!
            </h1>
            <!-- Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row justify-center items-center md:justify-center gap-4">
                <button>
                <a href="{{ route('login') }}" class="btn">
                    <span>
                        Login
                    </span>
                </a>
                </button>
                <button>
                <a href="{{ route('register') }}"
                   class="btn">
                    <span>
                    Register
                    </span>
                </a>
                </button>
                <button>
                <a href="{{ url('/admin') }}"
                   class="btn">
                    <span>
                    Admin Panel
                    </span>
                </a>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hero Section -->
<section class="mt-20 px-8 text-center max-w-7xl">
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center text-center md:text-left">
        <div class="md:col-span-3 text-center">
            <h2 class="text-3xl font-bold text-[#10b981] animate-fadeIn">Why Choose Saree3?</h2>
            <p class="mt-4 text-lg animate-fadeIn">Because waiting forever for deliveries is so last century! We promise
                you the speed
                of a cheetah (but in shipping) and the reliability of your grandma's best recipes.</p>
        </div>
        <div class="md:col-span-3">
            <img src="{{ asset('images/fast_snail.png') }}" alt="Saree3 Snail"
                 class="mx-auto mt-6 rounded-lg w-3/4 animate-forwardSlow">
        </div>
    </div>
</section>


<!-- Customer Testimonials -->
<section class="mt-16 px-8 text-center max-w-4xl">
    <h2 class="text-3xl font-bold text-[#10b981]">What Our Customers Say</h2>
    <div class="cards mt-10 grid grid-cols-1 md:grid-cols-4 gap-20 items-center text-center md:text-left">
        <div class="card">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <p class="title">Ahmed</p>
                        <p>Hover and see!</p>
                    </div>
                    <div class="flip-card-back">
                        <p class="title">I'm shocked!</p>
                        <p class="italic">I blinked, and my package was already here! Are they using teleportation?</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <p class="title">Sara</p>
                        <p>Hover and see!</p>
                    </div>
                    <div class="flip-card-back">
                        <p class="title">That was quick!</p>
                        <p class="italic">Finally, a delivery service that doesn’t make me wait a century!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <p class="title">Saif</p>
                        <p>Hover and see!</p>
                    </div>
                    <div class="flip-card-back">
                        <p class="title">Best shipping ever!</p>
                        <p class="italic">I couldn't believe I can have my order that quick</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <p class="title">Hamoksha</p>
                        <p>Hover and see!</p>
                    </div>
                    <div class="flip-card-back">
                        <p class="title">So Amazed by speed!</p>
                        <p class="italic">I'm a merchant and that was the quickest time to deliver an order</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="mt-16 bg-[#202022] text-white py-8 text-center w-full">
    <div class="mb-4">
        <h3 class="text-xl font-semibold">Stay Connected</h3>
        <p>Follow us on:</p>
        <div class="flex justify-center gap-20 mt-2">
            <a href="https://www.youtube.com/shorts/eB8riDrceVg" target="_blank" class="text-lg"><i
                    class="fa-brands fa-facebook"></i></a>
            <a href="https://www.youtube.com/shorts/6name2TWN-A" target="_blank" class="text-lg"><i
                    class="fa-brands fa-twitter"></i></a>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="text-lg"><i
                    class="fa-brands fa-youtube"></i></a>
            <a href="https://discord.gg/GyAWjMqr" target="_blank" class="text-lg"><i class="fa-brands fa-discord"></i></a>
            <a href="https://www.youtube.com/shorts/isRx40p7doI" target="_blank" class="text-lg"><i
                    class="fa-brands fa-whatsapp"></i></a>
        </div>
    </div>
    <div class="mb-8">
        <h3 class="text-xl font-semibold my-3">Track Your Order</h3>
        <input type="text" placeholder="Enter Tracking Number" class="px-4 py-2 rounded-lg text-black">
        <button class="px-4 py-2 bg-white text-[#0e9e74] rounded-lg ml-2">Track</button>
    </div>
    <div>
        <p>&copy; 2025 Saree3. Powered by speed, humor, and a little bit of magic.</p>
        <p class="mt-2 text-sm italic">Warning: Our speed may cause extreme excitement! Proceed with caution.</p>
    </div>
</footer>

<style>
    * {
        font-family: "Poppins", serif;
    }

    /*animation*/
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes bounceSlow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes forwardSlow {
        0%, 100% {
            transform: translateX(0);
        }
        50% {
            transform: translateX(-40px);
        }
    }

    .animate-forwardSlow {
        animation: forwardSlow 3s infinite ease-in-out;
    }

    .animate-bounceSlow {
        animation: bounceSlow 3s infinite ease-in-out;
    }

    /*end of animation*/

    /*Card Styling*/
    .flip-card {
        background-color: transparent;
        width: 200px;
        height: 264px;
        perspective: 1000px;
    }

    .title {
        font-size: 1.5em;
        font-weight: 900;
        text-align: center;
        margin: 0;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 1s;
        transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        box-shadow: 0 8px 14px 0 rgba(0, 0, 0, 0.2);
        position: absolute;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border: 1px solid #10b981;
        border-radius: 1rem;
    }

    .flip-card-front {
        background: linear-gradient(120deg, #0f766e 30%, #10b981 60%,
        #059669 80%, #064e3b 100%);
        color: white;
    }

    .flip-card-back {
        background: linear-gradient(120deg, #064e3b 20%, #059669 50%,
        #10b981 80%, #0f766e 100%);
        color: white;
        transform: rotateY(180deg);
    }

    .fa-brands {
        font-size: 30px;
        transition: all 500ms;
    }

    .fa-facebook:hover {
        color: #0866ff;
    }

    .fa-twitter:hover {
        color: #24a4f2;
    }

    .fa-youtube:hover {
        color: #fe080a;
    }

    .fa-whatsapp:hover {
        color: #2cd46b;
    }

    .fa-discord:hover {
        color: #5865f2;
    }

    /* From Uiverse.io by TISEPSE */
    .btn {
        position: relative;
        display: inline-block;
        padding: 10px 30px;
        border: 2px solid #fefefe;
        color: #fefefe;
        text-decoration: none;
        font-weight: 600;
        font-size: 18px;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 6px;
        left: -2px;
        width: calc(100% + 4px);
        height: calc(100% - 12px);
        background-color: #212121;
        transition: 0.3s ease-in-out;
        transform: scaleY(1);
    }

    .btn:hover::before {
        transform: scaleY(0);
    }

    .btn::after {
        content: '';
        position: absolute;
        left: 6px;
        top: -2px;
        height: calc(100% + 4px);
        width: calc(100% - 12px);
        background-color: #212121;
        transition: 0.3s ease-in-out;
        transform: scaleX(1);
        transition-delay: 0.5s;
    }

    .btn:hover::after {
        transform: scaleX(0);
    }

    .btn span {
        position: relative;
        z-index: 3;
    }

    button {
        background-color: none;
        text-decoration: none;
        background-color: #212121;
        border: none;
    }



</style>
</body>
</html>
