@extends('layouts.sidebar_final')

@section('content')
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">
                Manage <span class="text-primary-custom">Team Members</span>
            </h2>

            <x-button variant="add-create" class="mb-6"
                    onclick="document.getElementById('addTeamMemberModal').showModal(); return false;">
                <i class='bx bx-plus-circle mr-2'></i> Add Team Member
            </x-button>

            @include('content.dynamic.addTeamMemberModal')

            <!-- Team Members Grid -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($teamMembers as $member)
                    <div
                        class="bg-white rounded-2xl shadow-md p-6 text-center border border-gray-100 hover:shadow-lg transition relative group">

                        <!-- Active/Inactive badge -->
                        <div class="absolute top-3 right-3">
                            <x-feedback-status.status-indicator
                                :status="$member->is_active ? 'success' : 'danger'"
                                :label="$member->is_active ? 'Displayed' : 'Not Displayed'" />
                        </div>

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
                                <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook" class="text-blue-600 hover:text-blue-700">
                                    <i class="bx bxl-facebook"></i>
                                </a>
                            @endif
                            @if ($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="text-blue-700 hover:text-blue-800">
                                    <i class="bx bxl-linkedin"></i>
                                </a>
                            @endif
                            @if ($member->twitter_url)
                                <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter" class="text-sky-500 hover:text-sky-600">
                                    <i class="bx bxl-twitter"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center space-x-3 mt-4">
                            <button type="button"
                                onclick="document.getElementById('updateForm-{{ $member->id }}').classList.toggle('hidden')"
                                class="text-yellow-500 hover:text-yellow-600 text-lg">
                                <i class="bx bx-edit"></i>
                            </button>

                            <form method="POST" action="{{ route('content.teamMembers.destroy', $member->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 text-lg">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Hidden Update Form -->
                        <form method="POST" action="{{ route('content.teamMembers.update', $member->id) }}"
                            class="mt-3 space-y-2 hidden text-left" id="updateForm-{{ $member->id }}">
                            @csrf
                            @method('PUT')

                            <x-form.input name="name" label="Name" value="{{ $member->name }}" required class="text-sm" />
                            <x-form.input name="position" label="Position" value="{{ $member->position }}" required class="text-sm" />

                            <x-form.input name="facebook_url" type="url" label="Facebook URL" value="{{ $member->facebook_url }}" class="text-sm" />
                            <x-form.input name="linkedin_url" type="url" label="LinkedIn URL" value="{{ $member->linkedin_url }}" class="text-sm" />
                            <x-form.input name="twitter_url" type="url" label="Twitter URL" value="{{ $member->twitter_url }}" class="text-sm" />

                            <x-form.textarea name="bio" label="Bio" rows="2" value="{{ $member->bio }}" class="text-sm" />

                            <!-- Active toggle (inside the update form) -->
                            <input type="hidden" name="is_active" value="0">
                            <x-form.toggle
                                name="is_active"
                                value="1"
                                :checked="$member->is_active"
                                label="Active"
                                onchange="this.form.submit()" />

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
