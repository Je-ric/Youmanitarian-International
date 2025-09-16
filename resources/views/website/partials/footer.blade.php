<footer class="w-full bg-[#1a2235] text-white py-16">
    <div class="text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold">
            Youmanitarian <br>
            <span class="text-[#FFB51B]">International</span>
        </h2>
    </div>

    <!-- CTA Buttons -->
    <div class="flex flex-wrap justify-center mb-16 gap-4">
        <x-button href="{{ route('website.programs') }}" variant="primary-outline" class="w-50">Be a Volunteer</x-button>
        <x-button href="{{ route('website.donate') }}" variant="secondary-outline" class="w-50">Donate</x-button>
    </div>

    <!-- Footer Links Grid -->
    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 grid grid-cols-1 md:grid-cols-4 gap-12 gap-y-8">
        <!-- Quick Links -->
        <div>
            <h3 class="text-lg font-bold uppercase mb-6">Quick Links</h3>
            <ul class="space-y-2 text-sm opacity-80">
                <li><a href="{{ route('website.index') }}" class="hover:text-amber-400 transition">Home</a></li>
                <li><a href="{{ route('website.about') }}" class="hover:text-amber-400 transition">About Us</a></li>
                <li><a href="{{ route('website.programs') }}" class="hover:text-amber-400 transition">Programs</a></li>
                <li><a href="{{ route('website.sponsors') }}" class="hover:text-amber-400 transition">Partners & Sponsorship</a></li>
                <li><a href="{{ route('website.team') }}" class="hover:text-amber-400 transition">Meet the Team</a></li>
                <li><a href="{{ route('website.donate') }}" class="hover:text-amber-400 transition">Donate</a></li>
            </ul>
        </div>

        <!-- What We Do -->
        <div>
            <h3 class="text-lg font-bold uppercase mb-6">What We Do</h3>
            <ul class="space-y-2 text-sm opacity-80">
                <li>Lorem Ipsum</li>
                <li>Lorem Ipsum</li>
                <li>Lorem Ipsum</li>
                <li>Lorem Ipsum</li>
                <li>Lorem Ipsum</li>
                <li>Lorem Ipsum</li>
            </ul>
        </div>

        <!-- Talk To Us -->
        <div>
            <h3 class="text-lg font-bold uppercase mb-6">Talk To Us</h3>
            <ul class="space-y-2 text-sm opacity-80">
                <li>support@ercom.com</li>
                <li>+66 2399 1145</li>
                <li><a href="#" class="hover:text-amber-400 transition">Contact Us</a></li>
                <li><a href="#" class="hover:text-amber-400 transition">Facebook</a></li>
            </ul>
        </div>

        <!-- Legal -->
        <div>
            <h3 class="text-lg font-bold uppercase mb-6">Legal</h3>
            <ul class="space-y-2 text-sm opacity-80">
                <li><a href="#" class="hover:text-amber-400 transition">General Info</a></li>
                <li><a href="#" class="hover:text-amber-400 transition">Privacy Policy</a></li>
                <li><a href="#" class="hover:text-amber-400 transition">Terms of Service</a></li>
            </ul>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-white/10 mt-12"></div>

    <!-- Bottom Section -->
    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 mt-6 flex flex-col md:flex-row items-center justify-between text-sm opacity-80 space-y-4 md:space-y-0">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Logo" class="w-20 h-auto rounded-full bg-white/10" />
            <p>© 2025. All Rights Reserved.</p>
        </div>

        <div class="flex items-center space-x-4">
            <a href="#" class="hover:text-amber-400 transition" aria-label="Facebook"><i class='bx bxl-facebook text-lg'></i></a>
            <a href="#" class="hover:text-amber-400 transition" aria-label="Twitter"><i class='bx bxl-twitter text-lg'></i></a>
            <a href="#" class="hover:text-amber-400 transition" aria-label="Instagram"><i class='bx bxl-instagram text-lg'></i></a>
        </div>
    </div>
</footer>
