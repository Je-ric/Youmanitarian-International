@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Edit Program</h1>

    <form action="{{ route('programs.update', $program) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Title</label>
            <input type="text" name="title" 
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" 
                value="{{ old('title', $program->title) }}" required>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Description</label>
            <textarea name="description" 
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" 
                rows="4" required>{{ old('description', $program->description) }}</textarea>
        </div>

        <!-- Grid for Dates and Location -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">Date</label>
                <input type="date" name="date" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" 
                    value="{{ old('date', \Carbon\Carbon::parse($program->date)->format('Y-m-d')) }}" required>
            </div>


            
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">Start Time</label>
                <input type="time" name="start_time" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" 
                    value="{{ old('start_time', \Carbon\Carbon::parse($program->start_time)->format('H:i')) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">End Time</label>
                <input type="time" name="end_time" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" 
                    value="{{ old('end_time', \Carbon\Carbon::parse($program->end_time)->format('H:i')) }}" required>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#1a2235] mb-1">Location (Optional)</label>
                <input type="text" name="location" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" 
                    value="{{ old('location', $program->location) }}">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#1a2235] mb-1">Volunteer Needed</label>
                <input type="number" name="volunteer_count" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
                value="{{ old('volunteer_count', $program->volunteer_count) }}">
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a017] transition-colors">
                Update Program
            </button>
            <a href="{{ route('programs.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
