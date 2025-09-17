@extends('layouts.sidebar_final')

@section('content')
<div class="max-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-full max-w-5xl py-12">
        <x-overview.card title="Important Notice" icon="bx-bell" variant="bordered">
            <h2 class="text-xl font-bold text-[rgb(26,34,53)] mb-4">Volunteer Application</h2>

            <!-- DaisyUI Steps (compact) -->
            <ul id="steps" class="steps steps-horizontal steps-sm w-full mb-4">
                <li class="step step-primary" data-step-indicator="1">Motivation</li>
                <li class="step" data-step-indicator="2">Availability</li>
                <li class="step" data-step-indicator="3">Emergency</li>
                <li class="step" data-step-indicator="4">Reflection</li>
            </ul>

            <form id="volunteer-form" action="{{ route('volunteer.application.store') }}" method="POST" novalidate>
                @csrf

                <!-- Step 1: Personal Motivation -->
                <div class="space-y-4" data-step="1">
                    <div>
                        <x-form.label for="why_volunteer" variant="why-volunteer">Why do you want to volunteer?</x-form.label>
                        <x-form.textarea name="why_volunteer" placeholder="Share your motivation (max 300 characters)"
                            rows="3" maxlength="300" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-form.label for="interested_programs" variant="tasks">Interested Programs</x-form.label>
                            <x-form.input name="interested_programs" type="text" class="w-full" maxlength="255" required />
                        </div>

                        <div>
                            <x-form.label for="skills_experience" variant="description">Skills or Experience</x-form.label>
                            <x-form.input name="skills_experience" type="text" class="w-full" maxlength="255" />
                        </div>
                    </div>
                </div>

                <!-- Step 2: Availability & Health -->
                <div class="hidden space-y-4" data-step="2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-form.label for="availability" variant="time-info">Availability</x-form.label>
                            <x-form.input name="availability" type="text" class="w-full" maxlength="255" required />
                        </div>

                        <div>
                            <x-form.label for="commitment_hours" variant="time">Commitment Hours</x-form.label>
                            <x-form.input name="commitment_hours" type="text" class="w-full" maxlength="255" required />
                        </div>
                    </div>

                    <div>
                        <x-form.label for="physical_limitations" variant="notes">Physical Limitations</x-form.label>
                        <x-form.input name="physical_limitations" type="text" class="w-full" maxlength="255" />
                    </div>
                </div>

                <!-- Step 3: Emergency & Consent -->
                <div class="hidden space-y-4" data-step="3">
                    <div>
                        <x-form.label for="emergency_contact" variant="volunteer">Emergency Contact</x-form.label>
                        <x-form.input name="emergency_contact" type="text" class="w-full" maxlength="255" required />
                    </div>

                    <div>
                        <x-form.label for="contact_consent" variant="feedback">Emergency Contact Consent</x-form.label>
                        <x-form.radio-group name="contact_consent" :options="['yes' => 'Yes', 'no' => 'No']" required />
                    </div>
                </div>

                <!-- Step 4: Reflection -->
                <div class="hidden space-y-4" data-step="4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-form.label for="volunteered_before">Have you volunteered before?</x-form.label>
                            <x-form.radio-group name="volunteered_before" :options="['yes' => 'Yes', 'no' => 'No']" required />
                        </div>

                        <div>
                            <x-form.label for="outdoor_ok">Comfortable with outdoor/physical activities?</x-form.label>
                            <x-form.radio-group name="outdoor_ok" :options="['yes' => 'Yes', 'no' => 'No', 'depends' => 'Depends']" required />
                        </div>
                    </div>

                    <div>
                        <x-form.label for="short_bio" variant="short-bio">Short Bio</x-form.label>
                        <x-form.textarea name="short_bio" placeholder="Tell us a bit about yourself (max 300 characters)"
                            rows="3" maxlength="300" />
                    </div>
                </div>

                <!-- Navigation Buttons (compact) -->
                <div class="mt-6 flex items-center justify-between">
                    <x-button type="button" variant="secondary" id="prevBtn">
                        <i class="bx bx-left-arrow-alt mr-1"></i> Previous
                    </x-button>

                    <div class="flex items-center gap-2">
                        <x-button type="button" variant="primary" id="nextBtn">
                            Next <i class="bx bx-right-arrow-alt ml-1"></i>
                        </x-button>

                        <x-button type="submit" variant="success" id="submitBtn" class="hidden">
                            <i class="bx bx-send mr-1"></i> Submit
                        </x-button>
                    </div>
                </div>
            </form>
        </x-overview.card>
    </div>
</div>

<!-- Flowbite (if not already globally loaded) -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

<script>
    (function() {
        const steps = Array.from(document.querySelectorAll('[data-step]'));
        const indicators = Array.from(document.querySelectorAll('[data-step-indicator]'));
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('volunteer-form');

        let current = 0; // index in steps

        function showStep(index) {
            steps.forEach((el, i) => el.classList.toggle('hidden', i !== index));
            indicators.forEach((el, i) => el.classList.toggle('step-primary', i <= index));
            prevBtn.classList.toggle('invisible', index === 0);
            nextBtn.classList.toggle('hidden', index === steps.length - 1);
            submitBtn.classList.toggle('hidden', index !== steps.length - 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateCurrentStep() {
            const currentStepEl = steps[current];
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            for (const field of requiredFields) {
                if (field.type === 'radio') {
                    const checked = currentStepEl.querySelector(`input[name="${field.name}"]:checked`);
                    if (!checked) return (field.reportValidity && field.reportValidity()), false;
                } else if (!field.value) {
                    return (field.reportValidity && field.reportValidity()), false;
                }
            }
            return true;
        }

        prevBtn.addEventListener('click', () => { if (current > 0) showStep(--current); });
        nextBtn.addEventListener('click', () => { if (validateCurrentStep() && current < steps.length - 1) showStep(++current); });

        // Init
        prevBtn.classList.add('invisible');
        showStep(current);

        form.addEventListener('submit', (e) => { if (!validateCurrentStep()) e.preventDefault(); });
    })();
</script>

<style>
    html, body { height: 100%; overflow: hidden; } /* keep page non-scrollable */
</style>
@endsection
