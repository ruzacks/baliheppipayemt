@extends('layout.admin-layout')

@section('main')
   

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit API Service</h1>

    
        @include('api_services.form')
       
</div>
@endsection