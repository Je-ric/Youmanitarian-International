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

        @include('content.dynamic.manageTeamMemberModal')

        @foreach ($teamMembers as $category => $members)
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 capitalize">
                    {{ $category }}
                </h3>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($members as $member)
                        <div class="bg-white rounded-2xl shadow-md p-6 text-center border border-gray-100 hover:shadow-lg transition relative group" draggable="true" data-id="{{ $member->id }}">
                            <div class="absolute top-3 right-3">
                                <x-feedback-status.status-indicator
                                    :status="$member->is_active ? 'success' : 'danger'"
                                    :label="$member->is_active ? 'Displayed' : 'Not Displayed'" />
                            </div>

                            <div class="w-32 h-32 mx-auto mb-4 relative">
                                <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}" class="w-full h-full object-cover rounded-full border-4 border-primary-custom shadow">
                            </div>

                            <h3 class="text-xl font-bold text-gray-800">{{ $member->name }}</h3>
                            <p class="text-gray-500 text-sm mb-2">{{ $member->position }}</p>

                            @if ($member->bio)
                                <p class="mt-2 text-gray-600 text-sm">{{ $member->bio }}</p>
                            @endif

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

                            <div class="flex justify-center space-x-3 mt-4">
                                <x-button variant="edit"
                                    onclick="document.getElementById('editTeamMemberModal_{{ $member->id }}').showModal(); return false;"
                                    class="text-yellow-500 hover:text-yellow-600 text-lg">
                                    <i class="bx bx-edit"></i>
                                </x-button>
                                <form method="POST" action="{{ route('content.teamMembers.destroy', $member->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-lg">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @include('content.dynamic.manageTeamMemberModal', [
                            'isUpdate' => true,
                            'member' => $member,
                            'modalId' => 'editTeamMemberModal_' . $member->id
                        ])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
