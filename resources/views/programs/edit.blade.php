{{-- edit.blade.php --}}
@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto p-6">
    {{-- <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Edit Program</h1> --}}
    @include('programs._form', ['route' => route('programs.update', $program), 'method' => 'PUT', 'program' => $program])
</div>
@endsection
