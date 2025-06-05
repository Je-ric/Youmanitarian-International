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
