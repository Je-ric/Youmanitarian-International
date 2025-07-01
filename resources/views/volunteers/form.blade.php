@extends('layouts.sidebar_final')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <form action="{{ route('volunteer.application.store') }}" method="POST">
        @csrf

        <h2 class="text-2xl font-bold text-[#1a2235] mb-4">Volunteer Application Form</h2>

        <!-- Section 1: Personal Motivation -->
        <div class="mb-6">
            <x-form.label for="why_volunteer">Why do you want to volunteer?</x-form.label>
            <textarea name="why_volunteer" class="textarea textarea-bordered w-full" maxlength="500" required></textarea>
        </div>

        <div class="mb-6">
            <x-form.input name="interested_programs" type="text" label="Interested Programs" class="w-full" maxlength="255" required />
        </div>

        <div class="mb-6">
            <x-form.input name="skills_experience" type="text" label="Skills or Experience" class="w-full" maxlength="255" />
        </div>

        <!-- Section 2: Availability & Health -->
        <div class="mb-6">
            <x-form.input name="availability" type="text" label="Availability" class="w-full" maxlength="255" required />
        </div>

        <div class="mb-6">
            <x-form.input name="commitment_hours" type="text" label="Commitment Hours" class="w-full" maxlength="255" required />
        </div>

        <div class="mb-6">
            <x-form.input name="physical_limitations" type="text" label="Physical Limitations" class="w-full" maxlength="255" />
        </div>

        <!-- Section 3: Emergency & Consent -->
        <div class="mb-6">
            <x-form.input name="emergency_contact" type="text" label="Emergency Contact" class="w-full" maxlength="255" required />
        </div>

        <div class="mb-6">
            <x-form.label for="emergency_contact_consent">Emergency Contact Consent</x-form.label>
            <x-form.radio-group name="contact_consent" :options="['yes' => 'Yes', 'no' => 'No']" required />
        </div>

        <!-- Section 4: Reflection -->
        <div class="mb-6">
            <x-form.label for="volunteered_before">Have you volunteered before?</x-form.label>
            <x-form.radio-group name="volunteered_before" :options="['yes' => 'Yes', 'no' => 'No']" required />
        </div>

        <div class="mb-6">
            <x-form.label for="outdoor_ok">Are you comfortable with outdoor or physical activities?</x-form.label>
            <x-form.radio-group name="outdoor_ok" :options="['yes' => 'Yes', 'no' => 'No', 'depends' => 'Depends']" required />
        </div>

        <div class="mb-6">
            <x-form.label for="short_bio">Short Bio</x-form.label>
            <textarea name="short_bio" class="textarea textarea-bordered w-full" maxlength="500"></textarea>
        </div>

        <!-- Submit -->
        <div class="text-right mt-6">
            <button type="submit" class="btn btn-success">Submit Application</button>
        </div>
    </form>
</div>
@endsection
