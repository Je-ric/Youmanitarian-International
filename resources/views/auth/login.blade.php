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
    </style>
</head>
<body class="min-h-screen bg-gray-50">

    <div class="flex min-h-screen">
        <!-- Left Side - Logo and Branding -->
        <div class="hidden lg:flex lg:w-1/2 logo-container items-center justify-center">
            <div class="text-center text-white p-8">
                <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Youmanitarian International" class="w-48 h-48 mx-auto mb-8 object-contain">
                <h1 class="text-4xl font-bold mb-4">Youmanitarian International</h1>
                <p class="text-xl text-gray-200 mb-6">Empowering communities through humanitarian service</p>
                <div class="space-y-2 text-gray-300">
                    <p class="flex items-center justify-center"><i class='bx bx-heart mr-2'></i> Compassionate Service</p>
                    <p class="flex items-center justify-center"><i class='bx bx-group mr-2'></i> Community Building</p>
                    <p class="flex items-center justify-center"><i class='bx bx-world mr-2'></i> Global Impact</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Authentication Forms -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                    <p class="text-gray-600">Sign in to your account or create a new one</p>
                </div>

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-error-circle text-red-500 mr-2'></i>
                            <span class="text-red-700">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class='bx bx-check-circle text-green-500 mr-2'></i>
                            <span class="text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <div id="login-form" class="glass-effect rounded-2xl p-8 shadow-xl">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Sign In</h3>

                    <form method="post" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-form.input
                                name="email"
                                type="email"
                                label="Email Address"
                                placeholder="Enter your email address"
                                required
                            />
                        </div>

                        <div>
                            <x-form.input
                                name="password"
                                type="password"
                                label="Password"
                                placeholder="Enter your password"
                                required
                            />
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#1a2235] focus:ring-[#ffb51b]">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-[#1a2235] hover:text-[#ffb51b] transition-colors">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-[#1a2235] hover:bg-[#2d3748] text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class='bx bx-log-in mr-2'></i>
                            Sign In
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Don't have an account?
                            <button onclick="toggleForms()" class="text-[#1a2235] hover:text-[#ffb51b] font-semibold transition-colors">
                                Create Account
                            </button>
                        </p>
                    </div>
                </div>

                <!-- Register Form -->
                <div id="register-form" class="glass-effect rounded-2xl p-8 shadow-xl hidden">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Create Account</h3>

                    <form method="post" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-form.input
                                name="name"
                                type="name"
                                label="Full Name"
                                placeholder="Enter your full name"
                                required
                            />
                        </div>

                        <div>
                            <x-form.input
                                name="email"
                                type="email"
                                label="Email Address"
                                placeholder="Enter your email address"
                                required
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-form.input
                                    name="password"
                                    type="password"
                                    label="Password"
                                    placeholder="Create password"
                                    required
                                />
                            </div>

                            <div>
                                <x-form.input
                                    name="password_confirmation"
                                    type="password"
                                    label="Confirm Password"
                                    placeholder="Confirm password"
                                    required
                                />
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#1a2235] hover:bg-[#2d3748] text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class='bx bx-user-plus mr-2'></i>
                            Create Account
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Already have an account?
                            <button onclick="toggleForms()" class="text-[#1a2235] hover:text-[#ffb51b] font-semibold transition-colors">
                                Sign In
                            </button>
                        </p>
                    </div>
                </div>

                <!-- Divider -->
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-gray-500 text-sm">OR</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Google OAuth -->
                <div class="glass-effect rounded-2xl p-6 shadow-xl">
                    <a href="{{ route('google.login') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg border border-gray-300 transition-colors duration-200 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/google-100.png') }}" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleForms() {
            const loginForm = document.getElementById("login-form");
            const registerForm = document.getElementById("register-form");

            loginForm.classList.toggle("hidden");
            registerForm.classList.toggle("hidden");
        }
    </script>

</body>
</html>
