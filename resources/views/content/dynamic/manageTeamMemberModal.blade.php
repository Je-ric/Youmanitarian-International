@php
    $isUpdate = isset($member) && !is_null($member);
@endphp
<x-modal.dialog id="{{ $modalId ?? 'addTeamMemberModal' }}" maxWidth="max-w-3xl">
    <x-modal.header>
        <div>
            <h2 id="modalTitle" class="text-2xl font-bold text-slate-900 tracking-tight">
                {{ $isUpdate ? 'Update Team Member' : 'Add Team Member' }}
            </h2>
            <p id="modalSubtitle" class="text-sm text-slate-600 mt-1">
                {{ $isUpdate ? 'Edit the details below to update the team member.' : 'Please fill in the details below to add a new team member.' }}
            </p>
        </div>
    </x-modal.header>
    <x-modal.body>
        @php
            $photoInputId = 'photo_' . ($modalId ?? 'addTeamMemberModal');
        @endphp
        <form id="form_{{ $modalId ?? 'addMemberForm' }}" method="POST"
            action="{{ $isUpdate ? route('content.teamMembers.update', $member->id) : route('content.teamMembers.store') }}"
            enctype="multipart/form-data" class="space-y-6">

            @csrf
            @if ($isUpdate)
                @method('PUT')
                <input type="hidden" id="memberId" name="member_id" value="{{ $member->id }}">
            @endif
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <x-form.label for="name" variant="user">Name</x-form.label>
                        <x-form.input id="name" name="name" type="text" :value="$isUpdate ? $member->name : old('name')" required
                            class="w-full" />
                    </div>
                    <div>
                        <x-form.label for="position" icon="bx-briefcase"
                            icon-color="text-indigo-600">Position</x-form.label>
                        <x-form.input id="position" name="position" type="text" :value="$isUpdate ? $member->position : old('position')" required
                            class="w-full" />
                    </div>

                    @php
                        $selectedCategory = old('category', $isUpdate ? $member->category ?? 'member' : 'member');
                        $categoryOptions = [
                            ['value' => 'founder', 'label' => 'Founder', 'selected' => $selectedCategory === 'founder'],
                            ['value' => 'executive','label' => 'Executive','selected' => $selectedCategory === 'executive'],
                            ['value' => 'member', 'label' => 'Member', 'selected' => $selectedCategory === 'member'],
                            // [
                            //     'value' => 'developer',
                            //     'label' => 'Developer',
                            //     'selected' => $selectedCategory === 'developer',
                            // ],
                        ];
                    @endphp
                    <x-form.select-option name="category" label="Category" :options="$categoryOptions"
                        class="focus:ring-primary-custom focus:border-primary-custom" required />

                    @if ($isUpdate)
                        <div class="grid gap-6 sm:grid-cols-2" id="updateOnlyFields">
                            <div class="flex items-center">
                                <x-form.toggle name="is_active" id="is_active" value="1"
                                    label="Active (Display on website)" :checked="$member->is_active" />
                            </div>
                        </div>
                    @endif

                    <div class="sm:col-span-2 flex items-center gap-6">
                        <div class="flex-1">
                            <x-form.label for="{{ $photoInputId }}" variant="image">Photo</x-form.label>
                            <x-form.input-upload name="photo" id="{{ $photoInputId }}" accept="image/*"
                                class="w-full">
                                <span id="photoHelperText">
                                    {{ $isUpdate ? 'JPG, PNG up to 5MB (leave empty to keep current photo)' : 'JPG, PNG up to 5MB' }}
                                </span>
                            </x-form.input-upload>
                        </div>
                        @if ($isUpdate && $member->photo_url)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}"
                                    class="w-24 h-24 object-cover border-4 border-primary-custom shadow">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Social Links</h3>
                <div class="grid gap-6 sm:grid-cols-3">
                    <div>
                        <x-form.label for="facebook_url" icon="bxl-facebook"
                            icon-color="text-blue-600">Facebook</x-form.label>
                        <x-form.input id="facebook_url" name="facebook_url" type="url" :value="$isUpdate ? $member->facebook_url : old('facebook_url')"
                            class="w-full" />
                    </div>
                    <div>
                        <x-form.label for="linkedin_url" icon="bxl-linkedin"
                            icon-color="text-blue-700">LinkedIn</x-form.label>
                        <x-form.input id="linkedin_url" name="linkedin_url" type="url" :value="$isUpdate ? $member->linkedin_url : old('linkedin_url')"
                            class="w-full" />
                    </div>
                    <div>
                        <x-form.label for="twitter_url" icon="bxl-twitter"
                            icon-color="text-sky-500">Twitter</x-form.label>
                        <x-form.input id="twitter_url" name="twitter_url" type="url" :value="$isUpdate ? $member->twitter_url : old('twitter_url')"
                            class="w-full" />
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <x-form.label for="bio" variant="short-bio">Bio</x-form.label>
                    <x-form.textarea id="bio" name="bio" rows="3" class="w-full" :value="$isUpdate ? $member->bio : old('bio')">
                        {{ old('bio', $isUpdate ? $member->bio ?? '' : '') }}
                    </x-form.textarea>
                </div>
            </div>
        </form>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.close-button :modalId="$modalId ?? 'addTeamMemberModal'" text="Cancel" />
        <x-button type="submit" form="form_{{ $modalId ?? 'addMemberForm' }}"
            class="px-6 py-3 rounded-xl bg-primary-custom text-white font-medium shadow hover:bg-primary-dark">
            {{ $isUpdate ? 'Update' : 'Save' }}
        </x-button>

    </x-modal.footer>
</x-modal.dialog>
