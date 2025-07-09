@extends('layouts.sidebar_final')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Create New Program</h1>
                <p class="mt-2 text-sm text-gray-600">Fill in the details below to create a new volunteer program.</p>
            </div>

            <form action="{{ route('programs.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <x-form.label for="title" variant="title">Program Title</x-form.label>
                        <x-form.input
                            id="title"
                            name="title"
                            type="text"
                            placeholder="Enter program title"
                            class="mt-1"
                            value="{{ old('title') }}"
                            required
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <x-form.label for="date" variant="date">Date</x-form.label>
                            <x-form.date-picker
                                id="date"
                                name="date"
                                :value="old('date')"
                                required="true"
                            />
                        </div>

                        <div>
                            <x-form.label for="start_time" variant="start-time">Start Time</x-form.label>
                            <x-form.time-picker
                                id="start_time"
                                name="start_time"
                                :value="old('start_time')"
                                required="true"
                            />
                        </div>

                        <div>
                            <x-form.label for="end_time" variant="end-time">End Time</x-form.label>
                            <x-form.time-picker
                                id="end_time"
                                name="end_time"
                                :value="old('end_time')"
                                required="true"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-form.label for="location" variant="location">Location (Optional)</x-form.label>
                            <input
                                type="text"
                                id="location"
                                name="location"
                                placeholder="Enter location"
                                class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                                value="{{ old('location') }}"
                            >
                        </div>

                        <div>
                            <x-form.label for="volunteer_count" variant="volunteer-count">Volunteers Needed</x-form.label>
                            <input
                                type="number"
                                id="volunteer_count"
                                name="volunteer_count"
                                placeholder="Number of volunteers"
                                min="0"
                                class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                                value="{{ old('volunteer_count') }}"
                            >
                        </div>
                    </div>

                    <div>
                        <x-form.label for="description" variant="description">Description</x-form.label>
                        <x-form.textarea
                            id="description"
                            name="description"
                            placeholder="Write a detailed description of the program"
                            rows="6"
                            class="mt-1"
                            required
                        >{{ old('description') }}</x-form.textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6">
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-black rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black/20 transition-colors">
                        Create Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
