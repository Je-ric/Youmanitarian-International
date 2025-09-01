@extends('layouts.sidebar_final')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">
                Manage <span class="text-primary-custom">Team Members</span>
            </h2>

            <div class="bg-white p-6 rounded-2xl shadow-md mb-10">
                <h3 class="text-xl font-semibold mb-4">Add New Team Member</h3>
                <form method="POST" action="{{ route('content.teamMembers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" class="w-full border rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Position</label>
                            <input type="text" name="position" class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Photo</label>
                            <input type="file" name="photo" class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Facebook</label>
                            <input type="url" name="facebook_url" class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">LinkedIn</label>
                            <input type="url" name="linkedin_url" class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Twitter</label>
                            <input type="url" name="twitter_url" class="w-full border rounded-lg p-2">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium">Short Bio</label>
                            <textarea name="short_bio" class="w-full border rounded-lg p-2"></textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="px-6 py-2 rounded-lg hover:bg-primary-dark">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($teamMembers as $member)
                    <div class="bg-white rounded-2xl shadow-md p-6 text-center relative">

                        <div class="w-32 h-32 mx-auto mb-4">
                            <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}"
                                class="w-full h-full object-cover rounded-full border-4 border-primary-custom">
                        </div>

                        <h3 class="text-xl font-semibold">{{ $member->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $member->position }}</p>

                        @if ($member->short_bio)
                            <p class="mt-3 text-gray-600 text-sm">{{ $member->short_bio }}</p>
                        @endif

                        <div class="flex justify-center space-x-4 mt-4">
                            @if ($member->facebook_url)
                                <a href="{{ $member->facebook_url }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="bx bxl-facebook text-xl"></i>
                                </a>
                            @endif
                            @if ($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank"
                                    class="text-blue-700 hover:text-blue-900">
                                    <i class="bx bxl-linkedin text-xl"></i>
                                </a>
                            @endif
                            @if ($member->twitter_url)
                                <a href="{{ $member->twitter_url }}" target="_blank"
                                    class="text-sky-500 hover:text-sky-700">
                                    <i class="bx bxl-twitter text-xl"></i>
                                </a>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('content.teamMembers.update', $member->id) }}"
                            enctype="multipart/form-data" class="mt-4 space-y-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $member->name }}"
                                class="w-full border rounded-lg p-2 text-sm">
                            <input type="text" name="position" value="{{ $member->position }}"
                                class="w-full border rounded-lg p-2 text-sm">
                            <input type="file" name="photo" class="w-full border rounded-lg p-2 text-sm">
                            <textarea name="short_bio" class="w-full border rounded-lg p-2 text-sm">{{ $member->short_bio }}</textarea>

                            <button type="submit"
                                class="px-4 py-1 bg-yellow-500 text-white rounded-lg text-sm hover:bg-yellow-600">
                                Update
                            </button>
                        </form>

                        <form method="POST" action="{{ route('content.teamMembers.destroy', $member->id) }}"
                            class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-1 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to delete this member?')">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
