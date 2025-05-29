{{-- create.blade.php --}}
@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Create Program</h1>
    @include('programs._form', ['route' => route('programs.store'), 'method' => 'POST'])
</div>
@endsection
