@extends('layouts.navbar')

@section('content')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .form-container {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .logo-container {
            background: linear-gradient(135deg, #1a2235 0%, #2d3748 100%);
        }
        .illustration-container {
            background: linear-gradient(135deg, #1a2235 0%, #2d3748 100%);
            position: relative;
            overflow: hidden;
        }
        .form-transition {
            transition: all 0.3s ease;
        }
        .form-hidden {
            opacity: 0;
            transform: translateY(10px);
        }
        .form-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Added floating animation for illustration elements */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 181, 27, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        /* Added better spacing for form inputs */
        .form-input-group {
            margin-bottom: 1.5rem;
        }
        .form-input {
            padding: 1rem 0 0.5rem 0;
            margin-top: 0.5rem;
        }
        .form-label {
            top: 1rem;
        }
    </style>
<body class="min-h-screen bg-gray-50">

    <div class="flex min-h-screen">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-3">Youmanitarian International</h2>
                </div>

                <div id="login-form" class="glass-effect rounded-2xl p-8 shadow-xl form-transition form-visible">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Sign In</h3>

                    <form method="post" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Improved spacing and styling for form inputs -->
                        <div class="relative z-0 w-full form-input-group">
                            <input type="email" name="email" id="floating_email" class="form-input block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-amber-500 peer" placeholder=" " required />
                            <label for="floating_email" class="form-label peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-amber-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                        </div>

                        <div class="relative z-0 w-full form-input-group">
                            <input type="password" name="password" id="floating_password" class="form-input block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-amber-500 peer" placeholder=" " required />
                            <label for="floating_password" class="form-label peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-amber-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-amber-600 hover:text-amber-800 transition-colors">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-200 mt-6">
                            Sign in
                        </button>
                    </form>

                    <div class="my-6 flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-3 text-gray-500 text-sm">OR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <a href="{{ route('google.login') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg border border-gray-300 transition-colors duration-200 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/google-100.png') }}" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600 text-sm">
                            Don't have an account?
                            <button onclick="toggleForms()" class="text-amber-600 hover:text-amber-800 font-semibold transition-colors">
                                Register here
                            </button>
                        </p>
                    </div>
                </div>

                <div id="register-form" class="glass-effect rounded-2xl p-8 shadow-xl form-transition form-hidden" style="display: none;">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Create Account</h3>

                    <form method="post" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div class="relative z-0 w-full form-input-group">
                            <input type="text" name="name" id="floating_name" class="form-input block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-amber-500 peer" placeholder=" " required />
                            <label for="floating_name" class="form-label peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-amber-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Full name</label>
                        </div>

                        <div class="relative z-0 w-full form-input-group">
                            <input type="email" name="email" id="floating_register_email" class="form-input block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-amber-500 peer" placeholder=" " required />
                            <label for="floating_register_email" class="form-label peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-amber-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full form-input-group">
                                <input type="password" name="password" id="floating_register_password" class="form-input block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-amber-500 peer" placeholder=" " required />
                                <label for="floating_register_password" class="form-label peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-amber-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                            </div>
                            <div class="relative z-0 w-full form-input-group">
                                <input type="password" name="password_confirmation" id="floating_confirm_password" class="form-input block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-amber-500 peer" placeholder=" " required />
                                <label for="floating_confirm_password" class="form-label peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-amber-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-200 mt-6">
                            Create Account
                        </button>
                    </form>

                    <div class="my-6 flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-3 text-gray-500 text-sm">OR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <a href="{{ route('google.login') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg border border-gray-300 transition-colors duration-200 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/google-100.png') }}" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600 text-sm">
                            Already have an account?
                            <button onclick="toggleForms()" class="text-amber-600 hover:text-amber-800 font-semibold transition-colors">
                                Sign In
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced illustration area with animated elements and organizational info -->
        <div class="hidden lg:flex lg:w-1/2 illustration-container items-center justify-center p-8 relative">

            <img src="{{ asset('assets/images/bg/program-bg.jpg') }}" alt="Community Illustration" class="absolute inset-0 w-full h-full object-cover opacity-30">

            <div class="text-center space-y-8 relative z-10">
                <div class="mb-8">
                    <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Youmanitarian International" class="w-48 h-48 mx-auto mb-6 object-contain rounded-full border-4 border-amber-400 shadow-2xl">
                    <h3 class="text-3xl font-bold text-white mb-4">Join Our Community</h3>
                    <p class="text-gray-300 text-lg leading-relaxed max-w-md mx-auto">
                        Connect with like-minded individuals working together to create positive change in communities worldwide.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 max-w-sm mx-auto">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-group text-2xl text-white'></i>
                        </div>
                        <h4 class="text-white font-semibold mb-1">Community</h4>
                        <p class="text-gray-300 text-sm">Connect & Collaborate</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-heart text-2xl text-white'></i>
                        </div>
                        <h4 class="text-white font-semibold mb-1">Impact</h4>
                        <p class="text-gray-300 text-sm">Make a Difference</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-world text-2xl text-white'></i>
                        </div>
                        <h4 class="text-white font-semibold mb-1">Global</h4>
                        <p class="text-gray-300 text-sm">Worldwide Reach</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-trophy text-2xl text-white'></i>
                        </div>
                        <h4 class="text-white font-semibold mb-1">Excellence</h4>
                        <p class="text-gray-300 text-sm">Quality Programs</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleForms() {
            const loginForm = document.getElementById("login-form");
            const registerForm = document.getElementById("register-form");

            if (loginForm.style.display === "none") {
                // Show login form, hide register form
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                loginForm.classList.remove("form-hidden");
                loginForm.classList.add("form-visible");
                registerForm.classList.remove("form-visible");
                registerForm.classList.add("form-hidden");
            } else {
                // Show register form, hide login form
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                loginForm.classList.remove("form-visible");
                loginForm.classList.add("form-hidden");
                registerForm.classList.remove("form-hidden");
                registerForm.classList.add("form-visible");
            }
        }
    </script>

</body>
@endsection
