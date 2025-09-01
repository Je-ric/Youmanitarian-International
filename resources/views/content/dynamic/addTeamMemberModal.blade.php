<x-modal.dialog id="addTeamMemberModal" maxWidth="max-w-3xl">
    <x-modal.header>
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Add Team Member</h2>
            <p class="text-sm text-slate-600 mt-1">Please fill in the details below to add a new team member.</p>
        </div>
    </x-modal.header>

    <x-modal.body>
        <form id="addMemberForm" method="POST" action="{{ route('content.teamMembers.store') }}"
            enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Personal Information --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <x-form.label for="name" variant="user">Name</x-form.label>
                        <x-form.input id="name" name="name" type="text" :value="old('name')" required class="w-full" />
                    </div>

                    <div>
                        <x-form.label for="position" icon="bx-briefcase" icon-color="text-indigo-600">Position</x-form.label>
                        <x-form.input id="position" name="position" type="text" :value="old('position')" required class="w-full" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-form.label for="photo" variant="image">Photo</x-form.label>
                        <x-form.input-upload name="photo" id="photo" accept="image/*" required class="w-full">
                            JPG, PNG up to 5MB
                        </x-form.input-upload>
                    </div>
                </div>
            </div>

            {{-- Social Links --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Social Links</h3>
                <div class="grid gap-6 sm:grid-cols-3">
                    <div>
                        <x-form.label for="facebook_url" icon="bxl-facebook" icon-color="text-blue-600">Facebook</x-form.label>
                        <x-form.input id="facebook_url" name="facebook_url" type="url" :value="old('facebook_url')" class="w-full" />
                    </div>

                    <div>
                        <x-form.label for="linkedin_url" icon="bxl-linkedin" icon-color="text-blue-700">LinkedIn</x-form.label>
                        <x-form.input id="linkedin_url" name="linkedin_url" type="url" :value="old('linkedin_url')" class="w-full" />
                    </div>

                    <div>
                        <x-form.label for="twitter_url" icon="bxl-twitter" icon-color="text-sky-500">Twitter</x-form.label>
                        <x-form.input id="twitter_url" name="twitter_url" type="url" :value="old('twitter_url')" class="w-full" />
                    </div>
                </div>
            </div>

            {{-- Bio --}}
            <div>
                {{-- <h3 class="text-lg font-semibold text-gray-700 mb-4">Bio</h3> --}}
                <x-form.label for="bio" variant="short-bio">Bio</x-form.label>
                <x-form.textarea id="bio" name="bio" rows="3" class="w-full">{{ old('bio') }}</x-form.textarea>
            </div>

        </form>
    </x-modal.body>

    <x-modal.footer>
        <x-modal.close-button :modalId="'addTeamMemberModal'" text="Cancel" />
        <x-button type="submit" form="addMemberForm"
            class="px-6 py-3 rounded-xl bg-primary-custom text-white font-medium shadow hover:bg-primary-dark">
            Save
        </x-button>
    </x-modal.footer>
</x-modal.dialog>
