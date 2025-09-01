@extends('layouts.sidebar_final')

@section('content')
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">
                Manage <span class="text-primary-custom">Team Members</span>
            </h2>

            <!-- Add Member Form -->
            <div class="bg-white p-8 rounded-2xl shadow-lg mb-12 border border-gray-100">
                <h3 class="text-2xl font-semibold mb-6 text-gray-800">➕ Add New Team Member</h3>
                <form method="POST" action="{{ route('content.teamMembers.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" name="position" required
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Photo</label>
                            <input type="file" name="photo" required
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facebook</label>
                            <input type="url" name="facebook_url"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">LinkedIn</label>
                            <input type="url" name="linkedin_url"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Twitter</label>
                            <input type="url" name="twitter_url"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" rows="3"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-primary-custom focus:border-primary-custom p-3"></textarea>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-primary-custom text-white font-medium shadow hover:bg-primary-dark transition">
                            Save Member
                        </button>
                    </div>
                </form>
            </div>

            <!-- Team Members Grid -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($teamMembers as $member)
                    <div
                        class="bg-white rounded-2xl shadow-md p-6 text-center border border-gray-100 hover:shadow-lg transition relative group">

                        <!-- Photo with Hover Change Button -->
                        <div class="w-32 h-32 mx-auto mb-4 relative">
                            <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}"
                                class="w-full h-full object-cover rounded-full border-4 border-primary-custom shadow">
                            <form method="POST" action="{{ route('content.teamMembers.update', $member->id) }}"
                                enctype="multipart/form-data"
                                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition rounded-full">
                                @csrf
                                @method('PUT')

                                <!-- Include required fields as hidden -->
                                <input type="hidden" name="name" value="{{ $member->name }}">
                                <input type="hidden" name="position" value="{{ $member->position }}">

                                <label
                                    class="cursor-pointer text-white text-sm px-3 py-1 bg-primary-custom rounded-full hover:bg-primary-dark">
                                    Change
                                    <input type="file" name="photo" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>

                        </div>

                        <!-- Info -->
                        <h3 class="text-xl font-bold text-gray-800">{{ $member->name }}</h3>
                        <p class="text-gray-500 text-sm mb-2">{{ $member->position }}</p>
                        @if ($member->bio)
                            <p class="mt-2 text-gray-600 text-sm">{{ $member->bio }}</p>
                        @endif

                        <!-- Social Links -->
                        <div class="flex justify-center space-x-4 mt-3">
                            @if ($member->facebook_url)
                                <a href="{{ $member->facebook_url }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="bx bxl-facebook text-2xl"></i>
                                </a>
                            @endif
                            @if ($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank"
                                    class="text-blue-700 hover:text-blue-900 transition">
                                    <i class="bx bxl-linkedin text-2xl"></i>
                                </a>
                            @endif
                            @if ($member->twitter_url)
                                <a href="{{ $member->twitter_url }}" target="_blank"
                                    class="text-sky-500 hover:text-sky-700 transition">
                                    <i class="bx bxl-twitter text-2xl"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center space-x-3 mt-4">
                            <!-- Update Bio, Position & Links -->
                            <button type="button"
                                onclick="document.getElementById('updateForm-{{ $member->id }}').classList.toggle('hidden')"
                                class="text-yellow-500 hover:text-yellow-600 text-lg">
                                <i class="bx bx-edit"></i>
                            </button>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('content.teamMembers.destroy', $member->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 text-lg"
                                    onclick="return confirm('Are you sure you want to delete this member?')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Hidden Update Form -->
                        <form method="POST" action="{{ route('content.teamMembers.update', $member->id) }}"
                            class="mt-3 space-y-2 hidden" id="updateForm-{{ $member->id }}">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $member->name }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm p-2 text-sm" required>
                            <input type="text" name="position" value="{{ $member->position }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm p-2 text-sm" required>
                            <input type="url" name="facebook_url" value="{{ $member->facebook_url }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm p-2 text-sm">
                            <input type="url" name="linkedin_url" value="{{ $member->linkedin_url }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm p-2 text-sm">
                            <input type="url" name="twitter_url" value="{{ $member->twitter_url }}"
                                class="w-full border-gray-300 rounded-xl shadow-sm p-2 text-sm">
                            <textarea name="bio" rows="2" class="w-full border-gray-300 rounded-xl shadow-sm p-2 text-sm">{{ $member->bio }}</textarea>
                            <button type="submit"
                                class="w-full px-4 py-2 bg-yellow-500 text-white rounded-xl text-sm font-medium shadow hover:bg-yellow-600 transition">
                                Update
                            </button>
                        </form>

                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
