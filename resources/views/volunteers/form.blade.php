@extends('layouts.sidebar_final')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg" x-data="{ step: 1, hasVolunteered: null }">

  <!-- Step Indicator -->
  <ol class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-xs dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse mb-6">
    <li class="flex items-center" :class="step >= 1 ? 'text-[#ffb51b] dark:text-blue-500' : ''">
      <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0" :class="step >= 1 ? 'border-[#ffb51b] dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'">1</span>
      Personal <span class="hidden sm:inline-flex sm:ms-2">Info</span>
      <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" viewBox="0 0 12 10" fill="none">
        <path d="m7 9 4-4-4-4M1 9l4-4-4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
      </svg>
    </li>
    <li class="flex items-center" :class="step >= 2 ? 'text-[#ffb51b] dark:text-blue-500' : ''">
      <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0" :class="step >= 2 ? 'border-[#ffb51b] dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'">2</span>
      Volunteer <span class="hidden sm:inline-flex sm:ms-2">Details</span>
      <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" viewBox="0 0 12 10" fill="none">
        <path d="m7 9 4-4-4-4M1 9l4-4-4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
      </svg>
    </li>
    <li class="flex items-center" :class="step >= 3 ? 'text-[#ffb51b] dark:text-blue-500' : ''">
      <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0" :class="step >= 3 ? 'border-[#ffb51b] dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'">3</span>
      Reflection
      <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" viewBox="0 0 12 10" fill="none">
        <path d="m7 9 4-4-4-4M1 9l4-4-4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
      </svg>
    </li>
    <li class="flex items-center" :class="step === 4 ? 'text-[#ffb51b] dark:text-blue-500' : ''">
      <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border rounded-full shrink-0" :class="step === 4 ? 'border-[#ffb51b] dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'">4</span>
      Review
    </li>
  </ol>


<form action="{{ route('volunteer.application.store') }}" method="POST">
    @csrf

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg" x-data="{ step: 1, hasVolunteered: null, formData: {} }">
        <!-- Step 1: Personal Info -->
        <div x-show="step === 1" x-transition>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Why do you want to volunteer with us?</label>
                <input type="text" name="why_volunteer" class="input input-bordered w-full" placeholder="Your answer here..."
                    x-model="formData.why_volunteer">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">What type of programs are you interested in?</label>
                <input type="text" name="interested_programs" class="input input-bordered w-full" placeholder="e.g. Farming, Education, etc."
                    x-model="formData.interested_programs">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Do you have any relevant skills or experience?</label>
                <input type="text" name="skills_experience" class="input input-bordered w-full" placeholder="e.g. First Aid, Teaching, etc."
                    x-model="formData.skills_experience">
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-primary" @click="step++">Next</button>
            </div>
        </div>

        <!-- Step 2: Volunteer Details -->
        <div x-show="step === 2" x-transition>
          <!-- Availability Question -->
          <div class="mb-4">
              <label class="block font-semibold mb-1">Are you available on weekdays, weekends, or both?</label>
              <select name="availability" class="select select-bordered w-full" x-model="formData.availability">
                  <option value="weekdays">Weekdays</option>
                  <option value="weekends">Weekends</option>
                  <option value="both">Both</option>
              </select>
          </div>
      
          <!-- Commitment Hours Question -->
          <div class="mb-4">
              <label class="block font-semibold mb-1">How many hours per week can you commit?</label>
              <select name="commitment_hours" class="select select-bordered w-full" x-model="formData.commitment_hours">
                  <option value="less_than_5">Less than 5</option>
                  <option value="5_10">5–10</option>
                  <option value="10_15">10–15</option>
                  <option value="15_plus">15+</option>
              </select>
          </div>
      

            <div class="mb-4">
                <label class="block font-semibold mb-1">Do you have any physical limitations we should be aware of? <span class="text-sm text-gray-400">(Optional)</span></label>
                <input type="text" name="physical_limitations" class="input input-bordered w-full" placeholder="Optional..."
                    x-model="formData.physical_limitations">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Emergency Contact Name and Phone Number</label>
                <input type="text" name="emergency_contact" class="input input-bordered w-full" placeholder="Full name & phone number"
                    x-model="formData.emergency_contact">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Do you consent to be contacted in case of emergencies?</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="contact_consent" class="radio radio-primary" checked value="yes"
                            x-model="formData.contact_consent"> Yes</label>
                    <label><input type="radio" name="contact_consent" class="radio" value="no" x-model="formData.contact_consent"> No</label>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" class="btn" @click="step--">Back</button>
                <button type="button" class="btn btn-primary" @click="step++">Next</button>
            </div>
        </div>

        <!-- Step 3: Reflection -->
        <div x-show="step === 3" x-transition>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Have you volunteered before?</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="volunteered_before" class="radio" value="yes" @click="hasVolunteered = true"
                            x-model="formData.volunteered_before"> Yes</label>
                    <label><input type="radio" name="volunteered_before" class="radio" value="no" @click="hasVolunteered = false"
                            x-model="formData.volunteered_before"> No</label>
                </div>
                <div class="mt-2" x-show="hasVolunteered === true" x-transition>
                    <input type="text" name="previous_experience" class="input input-bordered w-full mt-2" placeholder="Where and what did you do?"
                        x-model="formData.previous_experience">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">What motivates you to help others?</label>
                <input type="text" name="motivation" class="input input-bordered w-full" placeholder="Your answer..."
                    x-model="formData.motivation">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Are you comfortable with outdoor or physical activities?</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="outdoor_ok" class="radio" value="yes" x-model="formData.outdoor_ok"> Yes</label>
                    <label><input type="radio" name="outdoor_ok" class="radio" value="no" x-model="formData.outdoor_ok"> No</label>
                    <label><input type="radio" name="outdoor_ok" class="radio" value="depends" x-model="formData.outdoor_ok"> Depends</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Tell us something about yourself <span class="text-sm text-gray-400">(Max 100 words)</span></label>
                <textarea name="short_bio" class="textarea textarea-bordered w-full" maxlength="600" placeholder="Write your short bio or anything you want to share..."
                    x-model="formData.short_bio"></textarea>
            </div>

            <div class="flex justify-between">
                <button type="button" class="btn" @click="step--">Back</button>
                <button type="button" class="btn btn-primary" @click="step++">Next</button>
            </div>
        </div>

        <!-- Step 4: Review -->
        <div x-show="step === 4" x-transition>
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-2">Review Your Answers</h2>
                <div class="mb-4">
                    {{-- <p><strong>Why do you want to volunteer?</strong> <span x-text="formData.why_volunteer"></span></p>
                    <p><strong>Interested Programs:</strong> <span x-text="formData.interested_programs"></span></p>
                    <p><strong>Skills/Experience:</strong> <span x-text="formData.skills_experience"></span></p>
                    <p><strong>Availability:</strong> <span x-text="formData.availability"></span></p>
                    <p><strong>Commitment Hours:</strong> <span x-text="formData.commitment_hours"></span></p>
                    <p><strong>Physical Limitations:</strong> <span x-text="formData.physical_limitations"></span></p>
                    <p><strong>Emergency Contact:</strong> <span x-text="formData.emergency_contact"></span></p>
                    <p><strong>Contact Consent:</strong> <span x-text="formData.contact_consent"></span></p>
                    <p><strong>Previous Volunteering:</strong> <span x-text="formData.volunteered_before"></span></p>
                    <p><strong>Motivation:</strong> <span x-text="formData.motivation"></span></p>
                    <p><strong>Outdoor Activities:</strong> <span x-text="formData.outdoor_ok"></span></p>
                    <p><strong>Short Bio:</strong> <span x-text="formData.short_bio"></span></p> --}}
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" class="btn" @click="step--">Back</button>
                <button type="submit" class="btn btn-success">Submit Application</button>
            </div>
        </div>
    </div>
</form>
@endsection