{{-- @extends('layouts.sidebar_final')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg" x-data="{ step: 1, formData: {} }">

    <form action="{{ route('volunteer.application.store') }}" method="POST">
        @csrf

        <!-- Stepper Navigation -->
        <div class="mb-6">
            <ol class="flex justify-between text-sm text-gray-600">
                <li :class="step === 1 ? 'font-bold text-[#ffb51b]' : ''">Step 1: Intro</li>
                <li :class="step === 2 ? 'font-bold text-[#ffb51b]' : ''">Step 2: Details</li>
                <li :class="step === 3 ? 'font-bold text-[#ffb51b]' : ''">Step 3: Reflection</li>
                <li :class="step === 4 ? 'font-bold text-[#ffb51b]' : ''">Step 4: Review</li>
            </ol>
        </div>

        <!-- Step 1 -->
        <div x-show="step === 1" x-transition>
            <div class="mb-4">
                <label class="font-semibold">Why do you want to volunteer?</label>
                <textarea name="why_volunteer" class="textarea textarea-bordered w-full" maxlength="500" x-model="formData.why_volunteer" required></textarea>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Interested Programs</label>
                <input type="text" name="interested_programs" class="input input-bordered w-full" maxlength="255" x-model="formData.interested_programs" required>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Skills or Experience</label>
                <input type="text" name="skills_experience" class="input input-bordered w-full" maxlength="255" x-model="formData.skills_experience">
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-primary" @click="step++">Next</button>
            </div>
        </div>

        <!-- Step 2 -->
        <div x-show="step === 2" x-transition>
            <div class="mb-4">
                <label class="font-semibold">Availability</label>
                <input type="text" name="availability" class="input input-bordered w-full" maxlength="255" x-model="formData.availability" required>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Commitment Hours</label>
                <input type="text" name="commitment_hours" class="input input-bordered w-full" maxlength="255" x-model="formData.commitment_hours" required>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Physical Limitations</label>
                <input type="text" name="physical_limitations" class="input input-bordered w-full" maxlength="255" x-model="formData.physical_limitations">
            </div>
            <div class="mb-4">
                <label class="font-semibold">Emergency Contact</label>
                <input type="text" name="emergency_contact" class="input input-bordered w-full" maxlength="255" x-model="formData.emergency_contact" required>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Emergency Contact Consent</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="contact_consent" value="yes" x-model="formData.contact_consent" required> Yes</label>
                    <label><input type="radio" name="contact_consent" value="no" x-model="formData.contact_consent"> No</label>
                </div>
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn" @click="step--">Back</button>
                <button type="button" class="btn btn-primary" @click="step++">Next</button>
            </div>
        </div>

        <!-- Step 3 -->
        <div x-show="step === 3" x-transition>
            <div class="mb-4">
                <label class="font-semibold">Have you volunteered before?</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="volunteered_before" value="yes" x-model="formData.volunteered_before" required> Yes</label>
                    <label><input type="radio" name="volunteered_before" value="no" x-model="formData.volunteered_before"> No</label>
                </div>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Are you comfortable with outdoor or physical activities?</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="outdoor_ok" value="yes" x-model="formData.outdoor_ok" required> Yes</label>
                    <label><input type="radio" name="outdoor_ok" value="no" x-model="formData.outdoor_ok"> No</label>
                    <label><input type="radio" name="outdoor_ok" value="depends" x-model="formData.outdoor_ok"> Depends</label>
                </div>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Short Bio</label>
                <textarea name="short_bio" class="textarea textarea-bordered w-full" maxlength="500" x-model="formData.short_bio"></textarea>
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn" @click="step--">Back</button>
                <button type="button" class="btn btn-primary" @click="step++">Next</button>
            </div>
        </div>

        <!-- Step 4 -->
        <div x-show="step === 4" x-transition>
            <div class="mb-4">
                <h2 class="text-lg font-bold mb-2">Review Your Answers</h2>
                <template x-for="(value, key) in formData" :key="key">
                    <p class="text-sm mb-1"><strong x-text="key.replaceAll('_', ' ').toUpperCase() + ':'"></strong> <span x-text="value"></span></p>
                </template>
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn" @click="step--">Back</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>

    </form>
</div>
@endsection --}}


@extends('layouts.sidebar_final')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <form action="{{ route('volunteer.application.store') }}" method="POST">
        @csrf

        <h2 class="text-2xl font-bold text-[#1a2235] mb-4">Volunteer Application Form</h2>

        <!-- Section 1: Personal Motivation -->
        <div class="mb-6">
            <label class="font-semibold">Why do you want to volunteer?</label>
            <textarea name="why_volunteer" class="textarea textarea-bordered w-full" maxlength="500" required></textarea>
        </div>

        <div class="mb-6">
            <label class="font-semibold">Interested Programs</label>
            <input type="text" name="interested_programs" class="input input-bordered w-full" maxlength="255" required>
        </div>

        <div class="mb-6">
            <label class="font-semibold">Skills or Experience</label>
            <input type="text" name="skills_experience" class="input input-bordered w-full" maxlength="255">
        </div>

        <!-- Section 2: Availability & Health -->
        <div class="mb-6">
            <label class="font-semibold">Availability</label>
            <input type="text" name="availability" class="input input-bordered w-full" maxlength="255" required>
        </div>

        <div class="mb-6">
            <label class="font-semibold">Commitment Hours</label>
            <input type="text" name="commitment_hours" class="input input-bordered w-full" maxlength="255" required>
        </div>

        <div class="mb-6">
            <label class="font-semibold">Physical Limitations</label>
            <input type="text" name="physical_limitations" class="input input-bordered w-full" maxlength="255">
        </div>

        <!-- Section 3: Emergency & Consent -->
        <div class="mb-6">
            <label class="font-semibold">Emergency Contact</label>
            <input type="text" name="emergency_contact" class="input input-bordered w-full" maxlength="255" required>
        </div>

        <div class="mb-6">
            <label class="font-semibold block mb-1">Emergency Contact Consent</label>
            <div class="flex gap-4">
                <label><input type="radio" name="contact_consent" value="yes" required> Yes</label>
                <label><input type="radio" name="contact_consent" value="no"> No</label>
            </div>
        </div>

        <!-- Section 4: Reflection -->
        <div class="mb-6">
            <label class="font-semibold block mb-1">Have you volunteered before?</label>
            <div class="flex gap-4">
                <label><input type="radio" name="volunteered_before" value="yes" required> Yes</label>
                <label><input type="radio" name="volunteered_before" value="no"> No</label>
            </div>
        </div>

        <div class="mb-6">
            <label class="font-semibold block mb-1">Are you comfortable with outdoor or physical activities?</label>
            <div class="flex gap-4">
                <label><input type="radio" name="outdoor_ok" value="yes" required> Yes</label>
                <label><input type="radio" name="outdoor_ok" value="no"> No</label>
                <label><input type="radio" name="outdoor_ok" value="depends"> Depends</label>
            </div>
        </div>

        <div class="mb-6">
            <label class="font-semibold">Short Bio</label>
            <textarea name="short_bio" class="textarea textarea-bordered w-full" maxlength="500"></textarea>
        </div>

        <!-- Submit -->
        <div class="text-right mt-6">
            <button type="submit" class="btn btn-success">Submit Application</button>
        </div>
    </form>
</div>
@endsection
