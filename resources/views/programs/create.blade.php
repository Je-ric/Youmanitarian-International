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
                        <label for="title" class="block text-sm font-medium text-gray-700">Program Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="Enter program title"
                            class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                            value="{{ old('title') }}"
                            required
                        >
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input
                                type="date"
                                id="date"
                                name="date"
                                class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                                value="{{ old('date') }}"
                                required
                            >
                        </div>

                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input
                                type="time"
                                id="start_time"
                                name="start_time"
                                class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                                value="{{ old('start_time') }}"
                                required
                            >
                        </div>

                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input
                                type="time"
                                id="end_time"
                                name="end_time"
                                class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                                value="{{ old('end_time') }}"
                                required
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location (Optional)</label>
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
                            <label for="volunteer_count" class="block text-sm font-medium text-gray-700">Volunteers Needed</label>
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
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            placeholder="Write a detailed description of the program"
                            rows="6"
                            class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 placeholder-gray-400 resize-y focus:border-black focus:ring-2 focus:ring-black/20 transition-colors"
                            required
                        >{{ old('description') }}</textarea>
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
