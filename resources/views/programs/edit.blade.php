
@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto p-6">
    @include('programs._form', ['route' => route('programs.update', $program), 'method' => 'PUT', 'program' => $program])
</div>
@endsection
