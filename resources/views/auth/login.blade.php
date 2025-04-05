{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.10/dist/full.css" rel="stylesheet">
    {{-- <script src="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/dist/boxicons.min.js"></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-[#1a2235]/70 to-[#ffb51b]/70">

    <div class="flex bg-white shadow-xl rounded-lg overflow-hidden w-full max-w-7xl">
        <div class="hidden md:flex md:w-1/2 justify-center items-center">
            <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Login Image" class="w-90 h-90 object-contain">
        </div>

        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-center text-black">YOUMANITARIAN INTERNATIONAL</h2>
            <p class="text-center text-gray-600">Fill out the information below to continue.</p>

            @if (session('error'))
                <div class="mb-4 p-3 text-red-600 bg-red-200 rounded">{{ session('error') }}</div>
            @endif

            <!-- Login Form -->
            <div id="login-form">
                <form method="post" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div class="form-control">
                        <label class="label">Email Address</label>
                        <input type="email" name="email" placeholder="Enter your email" required class="input input-bordered w-full">
                    </div>
                    <div class="form-control">
                        <label class="label">Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required class="input input-bordered w-full">
                    </div>
                    <button type="submit" class="btn btn-neutral w-full text-white">LOGIN</button>
                </form>

                <p class="mt-4 text-center">Don't have an account? 
                    <button onclick="toggleForms()" class="text-blue-500 hover:underline">Register</button>
                </p>
            </div>

            <!-- Register Form -->
            <div id="register-form" class="hidden">
                <form method="post" action="{{ route('register') }}" class="space-y-3">
                    @csrf
                    <div class="form-control">
                        <label class="label">Full Name</label>
                        <input type="text" name="name" placeholder="Full Name" required class="input input-bordered w-full">
                    </div>
                    <div class="form-control">
                        <label class="label">Email Address</label>
                        <input type="email" name="email" placeholder="Email" required class="input input-bordered w-full">
                    </div>

                    <div class="flex gap-2">
                        <div class="form-control w-1/2 relative">
                            <label class="label">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Password" required class="input input-bordered w-full pr-10">
                                <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-500" onclick="togglePassword('password', 'eye1')">
                                    <i class='bx bx-show text-xl' id="eye1"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-control w-1/2 relative">
                            <label class="label">Confirm Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="confirm-password" placeholder="Confirm Password" required class="input input-bordered w-full pr-10">
                                <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-500" onclick="togglePassword('confirm-password', 'eye2')">
                                    <i class='bx bx-show text-xl' id="eye2"></i>
                                </button>
                            </div>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-neutral w-full text-white">REGISTER</button>
                </form>

                <p class="mt-4 text-center">Already have an account? 
                    <button onclick="toggleForms()" class="text-blue-500 hover:underline">Login</button>
                </p>
            </div>


            <div class="divider my-6">OR</div>

            <a href="{{ route('google.login') }}" class="btn btn-neutral w-full">
                <img src="{{ asset('assets/images/icons/google-100.png') }}" class="w-6 h-6"> Continue with Google
            </a>

        </div>
    </div>

    <script>
        function toggleForms() {
            document.getElementById("login-form").classList.toggle("hidden");
            document.getElementById("register-form").classList.toggle("hidden");
        }

        function togglePassword(inputId, eyeId) {
            let input = document.getElementById(inputId);
            let eyeIcon = document.getElementById(eyeId);
    
            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.replace("bx-show", "bx-hide");
            } else {
                input.type = "password";
                eyeIcon.classList.replace("bx-hide", "bx-show");
            }
        }
    </script>

</body>
</html>
