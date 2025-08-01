<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - Youmanitarian International</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.10/dist/full.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
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
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
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
    </style>
</head>
<body class="min-h-screen bg-gray-50">

    <div class="flex min-h-screen">
        <!-- Left Side - Sign In Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Youmanitarian International</h2>
                    <p class="text-gray-600">Sign in to your account and explore a world of possibilities.</p>
                </div>

                <!-- Login Form -->
                <div id="login-form" class="glass-effect rounded-2xl p-6 shadow-xl form-transition form-visible">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Sign In</h3>

                    <form method="post" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="password" name="password" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                            Sign in
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-4 flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-3 text-gray-500 text-sm">OR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Google OAuth -->
                    <a href="{{ route('google.login') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-4 rounded-lg border border-gray-300 transition-colors duration-200 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/google-100.png') }}" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>

                    <div class="mt-4 text-center">
                        <p class="text-gray-600 text-sm">
                            Don't have an account?
                            <button onclick="toggleForms()" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                Register here
                            </button>
                        </p>
                    </div>
                </div>

                <!-- Register Form -->
                <div id="register-form" class="glass-effect rounded-2xl p-6 shadow-xl form-transition form-hidden" style="display: none;">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Create Account</h3>

                    <form method="post" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="name" id="floating_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_name" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Full name</label>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="email" name="email" id="floating_register_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_register_email" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="password" name="password" id="floating_register_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="floating_register_password" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="password" name="password_confirmation" id="floating_confirm_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="floating_confirm_password" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                            Create Account
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-4 flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-3 text-gray-500 text-sm">OR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Google OAuth -->
                    <a href="{{ route('google.login') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-4 rounded-lg border border-gray-300 transition-colors duration-200 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/google-100.png') }}" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>

                    <div class="mt-4 text-center">
                        <p class="text-gray-600 text-sm">
                            Already have an account?
                            <button onclick="toggleForms()" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                Sign In
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Conceptual Illustration -->
        <div class="hidden lg:flex lg:w-1/2 illustration-container items-center justify-center p-8">
            <div class="text-center space-y-8">
                <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Youmanitarian International" class="w-64 h-64 mx-auto mb-8 object-contain">
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
</html>
