@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-group" title="Manage Team Members"
        desc="View, add, and update your organization's team members in one place.">

        <x-button variant="add-create" onclick="document.getElementById('addTeamMemberModal').showModal(); return false;">
            <i class='bx bx-plus-circle mr-2'></i> Add Team Member
        </x-button>
    </x-page-header>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-feedback-status.alert
            variant="flexible"
            icon="bx bx-info-circle"
            bgColor="bg-blue-50"
            textColor="text-gray-700"
            borderColor="border-blue-200"
            iconColor="text-blue-500"
            :message="'The details you add here will be displayed on the <span class=\'font-semibold text-gray-800\'>Team Members</span> page of the website.'"
        />

        @include('content.dynamic.manageTeamMemberModal')

        @foreach ($teamMembers as $category => $members)
            <div class="mb-10 last:mb-0">
                <div class="mb-6">
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#1a2235] mb-2 capitalize tracking-tight">
                        {{ $category }}
                    </h3>
                    <div class="w-16 h-1 bg-[#ffb51b] rounded-full"></div>
                </div>

                <div class="grid gap-6 sm:gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($members as $member)

                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 text-center border border-[#ffb51b] hover:border-[#ffb51b]/20 transition-all duration-300 relative group transform hover:-translate-y-1"
                            data-id="{{ $member->id }}">

                            <div class="absolute top-4 right-4 z-10">
                                <x-feedback-status.status-indicator :status="$member->is_active ? 'success' : 'danger'" :label="$member->is_active ? 'Displayed' : 'Not Displayed'" />
                            </div>

                            <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto mb-4 relative">
                                <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}"
                                    class="w-full h-full object-cover rounded-full border-4 border-[#ffb51b] shadow-lg ring-4 ring-[#ffb51b]/10">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="space-y-3">
                                <h3 class="text-xl font-bold text-[#1a2235] leading-tight">{{ $member->name }}</h3>
                                <p class="text-gray-600 text-sm font-medium bg-gray-50 px-3 py-1 rounded-full inline-block">{{ $member->position }}</p>

                                @if ($member->bio)
                                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 px-2">{{ $member->bio }}</p>
                                @endif
                            </div>

                            @if ($member->facebook_url || $member->linkedin_url || $member->twitter_url)
                                <div class="flex justify-center space-x-4 mt-5 pt-4 border-t border-gray-100">
                                    @if ($member->facebook_url)
                                        <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener"
                                            aria-label="Facebook" class="w-8 h-8 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="bx bxl-facebook text-lg"></i>
                                        </a>
                                    @endif
                                    @if ($member->linkedin_url)
                                        <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener"
                                            aria-label="LinkedIn" class="w-8 h-8 bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="bx bxl-linkedin text-lg"></i>
                                        </a>
                                    @endif
                                    @if ($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter"
                                            class="w-8 h-8 bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="bx bxl-twitter text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="flex justify-center space-x-3 mt-6 pt-4 border-t border-gray-100">
                                <button type="button"
                                    onclick="document.getElementById('editTeamMemberModal_{{ $member->id }}').showModal(); return false;"
                                    class="w-9 h-9 bg-[#ffb51b]/10 text-[#ffb51b] hover:bg-[#ffb51b] hover:text-white rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
                                    <i class="bx bx-edit-alt text-lg"></i>
                                </button>
                                <form method="POST" action="{{ route('content.teamMembers.destroy', $member->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
                                        <i class="bx bx-trash text-lg"></i>
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
