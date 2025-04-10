@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Create Program</h1>

    <form action="{{ route('programs.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Title</label>
            <input type="text" name="title" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Description</label>
            <textarea name="description" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" rows="4" required></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">Start Date</label>
                <input type="date" name="start_date" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">End Date (Optional)</label>
                <input type="date" name="end_date" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors">
            </div>

              <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1a2235] mb-1">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors" required>
            </div>
        </div>
           <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#1a2235] mb-1">Location (Optional)</label>
                    <input type="text" name="location" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#1a2235] mb-1">Volunteer Needed</label>
                    <input type="number" name="volunteer_count" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors">
                </div>
           </div>

        <button type="submit" class="px-6 py-3 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a017] transition-colors">
            Create Program
        </button>
    </form>
</div>
@endsection