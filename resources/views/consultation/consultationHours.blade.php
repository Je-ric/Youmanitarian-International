@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-time" title="Consultation Hours" desc="Manage and set your available consultation times.">
    </x-page-header>

    <div class="py-10 px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- left --}}
            <div class="md:col-span-2">
                <x-overview.card
                    title="Your Consultation Hours"
                    icon="bx-time-five"
                    variant="midnight-header">
                    <p class="text-sm text-gray-500 mb-4">
                        These are the times when you're available for consultations with other volunteers.
                    </p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700 border rounded-lg w-full md:w-[65%]">
                            <thead class="text-xs font-semibold text-gray-500 border-b bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-2 px-3 text-left">Specialization</th>
                                    <th scope="col" class="py-2 px-3 text-left">Day</th>
                                    <th scope="col" class="py-2 px-3 text-left">Time</th>
                                    <th scope="col" class="py-2 px-3 text-left">Status</th>
                                    <th scope="col" class="py-2 px-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($consultationHours as $hour)
                                    <tr class="border-b last:border-0 hover:bg-gray-50">
                                        <td class="py-2 px-3 font-medium whitespace-nowrap">
                                            {{ $hour->specialization }}
                                        </td>
                                        <td class="py-2 px-3 whitespace-nowrap">
                                            {{ $hour->day }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ \Carbon\Carbon::parse($hour->start_time)->format('g:i A') }}
                                            –
                                            {{ \Carbon\Carbon::parse($hour->end_time)->format('g:i A') }}
                                        </td>
                                        <td class="py-2 px-3 whitespace-nowrap">
                                            <x-feedback-status.status-indicator
                                                :status="$hour->status"
                                                :label="ucfirst($hour->status)" />
                                        </td>

                                        <td class="py-2 px-3 flex justify-end items-center gap-1">

                                            <button type="button"
                                                class="p-1.5 text-gray-600 hover:text-blue-600 rounded-md transition edit-btn"
                                                data-id="{{ $hour->id }}"
                                                data-action="{{ route('consultation-hours.update', $hour->id) }}"
                                                data-specialization="{{ $hour->specialization }}"
                                                data-day="{{ $hour->day }}"
                                                data-start="{{ \Carbon\Carbon::parse($hour->start_time)->format('H:i') }}"
                                                data-end="{{ \Carbon\Carbon::parse($hour->end_time)->format('H:i') }}"
                                                data-status="{{ $hour->status }}"
                                                aria-label="Edit">
                                                <i class="bx bx-edit text-base"></i>
                                            </button>

                                            <form action="{{ route('consultation-hours.destroy', $hour->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this consultation hour?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-600 hover:text-red-600 rounded-md transition"
                                                    aria-label="Delete">
                                                    <i class="bx bx-trash text-base"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-3 text-center text-gray-500 text-sm">
                                            No consultation hours available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-overview.card>
            </div>



            {{-- right --}}
            <div class="md:col-span-1">
                <x-overview.card
                    title="Add Consultation Hours"
                    id="form-title"
                    icon="bx-plus-circle"
                    variant="midnight-header">
                    <p class="text-sm text-gray-500 mb-6">
                        Set times when you're available to provide consultations.
                    </p>

                    <form id="consultation-form"
                        action="{{ isset($editingHour)
                            ? route('consultation-hours.update', $editingHour->id)
                            : route('consultation-hours.store') }}"
                        method="POST" class="space-y-5">

                        @csrf

                        @if (isset($editingHour))
                            @method('PUT')
                        @endif
                        <input type="hidden" name="_method" value="{{ isset($editingHour) ? 'PUT' : 'POST' }}"
                                id="form-method">
                        <input type="hidden" name="id" id="consultation_id">

                        <div>
                            <x-form.label for="specialization" variant="task">Specialization</x-form.label>
                            <x-form.input name="specialization" id="specialization" placeholder="e.g., Mental Health Support"
                                value="{{ old('specialization', $editingHour->specialization ?? '') }}" required />
                        </div>

                        <div>
                            <x-form.label for="day" variant="date">Day of Week</x-form.label>
                            <select id="day" name="day" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] text-sm">
                                <option value="">Select day</option>
                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <option value="{{ $day }}" @selected(old('day', $editingHour->day ?? '') === $day)>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-form.label for="start_time" variant="start-time">Start Time</x-form.label>
                                <x-form.time-picker id="start_time" name="start_time"
                                    value="{{ old('start_time', $editingHour->start_time ?? '') }}" required />
                            </div>
                            <div>
                                <x-form.label for="end_time" variant="end-time">End Time</x-form.label>
                                <x-form.time-picker id="end_time" name="end_time"
                                    value="{{ old('end_time', $editingHour->end_time ?? '') }}" required />
                            </div>
                        </div>

                        <div>
                            <x-form.label variant="status">Status</x-form.label>
                            <x-form.radio-group name="status" :options="['active' => 'Active', 'inactive' => 'Inactive']" :selected="old('status', $editingHour->status ?? 'active')" inline />
                        </div>

                        <div class="flex gap-4">
                            <x-button type="submit" id="add-edit-btn" variant="primary" class="flex-1">
                                <i class="bx bx-plus text-lg"></i>Add Hours
                            </x-button>

                            <x-button variant="secondary" type="reset" id="cancel-btn" class="hidden flex-1">
                                <i class="bx bx-x-circle text-lg"></i>
                                Cancel
                            </x-button>
                        </div>

                    </form>
                </x-overview.card>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("consultation-form");
        const methodInput = document.getElementById("form-method");
        const consultationId = document.getElementById("consultation_id");
        const cancelBtn = document.getElementById("cancel-btn");
        const formTitle = document.getElementById("form-title");
        const addEditBtn = document.getElementById("add-edit-btn");

        // remember original (store) action and button HTML
        const originalAction = form.getAttribute("action");
        const originalBtnHtml = addEditBtn.innerHTML;

        document.querySelectorAll(".edit-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                // fill
                document.getElementById("specialization").value = btn.dataset.specialization;
                document.getElementById("day").value = btn.dataset.day;
                document.getElementById("start_time").value = btn.dataset.start;
                document.getElementById("end_time").value = btn.dataset.end;

                document.querySelectorAll("input[name='status']").forEach(radio => {
                    radio.checked = (radio.value === btn.dataset.status);
                });

                // Switch to Edit mode
                form.setAttribute("action", btn.dataset.action);
                methodInput.value = "PUT";
                consultationId.value = btn.dataset.id;

                addEditBtn.innerHTML = `<i class="bx bx-save text-lg"></i> Update Hours`;
                formTitle.textContent = "Update Consultation Hours";
                cancelBtn?.classList.remove("hidden");
            });
        });

        // reset to add mode
        form.addEventListener("reset", () => {
            // clear
            form.setAttribute("action", originalAction);
            methodInput.value = "POST";
            consultationId.value = "";

            addEditBtn.innerHTML = originalBtnHtml;
            formTitle.textContent = "Add Consultation Hours";
            cancelBtn?.classList.add("hidden");
        });
    });
</script>
