@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-group" title="Manage Team Members"
        desc="View, add, and update your organization's team members in one place.">

        <x-button variant="add-create" onclick="document.getElementById('addTeamMemberModal').showModal(); return false;">
            <i class='bx bx-plus-circle mr-2'></i> Add Team Member
        </x-button>
    </x-page-header>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-base sm:text-lg text-gray-600 font-medium leading-relaxed">
            The details you add here will be displayed on the
            <span class="font-semibold text-gray-800">Team Members</span> page of the website.
        </h2>


        @include('content.dynamic.manageTeamMemberModal')

        @foreach ($teamMembers as $category => $members)
            <div class="mb-8">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 capitalize">
                    {{ $category }}
                </h3>

                <div class="grid gap-4 sm:gap-5 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                    @foreach ($members as $member)
                        <div class="bg-white rounded-xl shadow-md p-4 text-center border border-gray-100 hover:shadow-lg transition-all duration-200 relative group"
                            draggable="true" data-id="{{ $member->id }}">
                            <div class="absolute top-2 right-2">
                                <x-feedback-status.status-indicator :status="$member->is_active ? 'success' : 'danger'" :label="$member->is_active ? 'Displayed' : 'Not Displayed'" />
                            </div>

                            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-3 relative">
                                <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}"
                                    class="w-full h-full object-cover rounded-full border-3 border-primary-custom shadow-sm">
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $member->name }}</h3>
                            <p class="text-gray-500 text-xs sm:text-sm mb-2 leading-tight">{{ $member->position }}</p>

                            @if ($member->bio)
                                <p class="mt-2 text-gray-600 text-xs leading-relaxed line-clamp-2">{{ $member->bio }}</p>
                            @endif

                            <div class="flex justify-center space-x-3 mt-2">
                                @if ($member->facebook_url)
                                    <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener"
                                        aria-label="Facebook" class="text-blue-600 hover:text-blue-700 text-sm">
                                        <i class="bx bxl-facebook"></i>
                                    </a>
                                @endif
                                @if ($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener"
                                        aria-label="LinkedIn" class="text-blue-700 hover:text-blue-800 text-sm">
                                        <i class="bx bxl-linkedin"></i>
                                    </a>
                                @endif
                                @if ($member->twitter_url)
                                    <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter"
                                        class="text-sky-500 hover:text-sky-600 text-sm">
                                        <i class="bx bxl-twitter"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="flex justify-center space-x-2 mt-3">
                                <button type="button"
                                    onclick="document.getElementById('editTeamMemberModal_{{ $member->id }}').showModal(); return false;"
                                    class="text-yellow-500 hover:text-yellow-600 text-sm p-1">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                                <form method="POST" action="{{ route('content.teamMembers.destroy', $member->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm p-1">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @include('content.dynamic.manageTeamMemberModal', [
                            'isUpdate' => true,
                            'member' => $member,
                            'modalId' => 'editTeamMemberModal_' . $member->id,
                        ])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
