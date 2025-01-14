@extends('layout.admin-layout')

@section('main')
   

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">API Services</h1>

    <a href="{{ route('api_services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 mb-4 inline-block">Create New Service</a>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Name</th>
                <th class="border border-gray-300 px-4 py-2" style="max-width: 500px;">Attributes</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apiServices as $service)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $service->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $service->name }}</td>
                    <td class="border border-gray-300 px-4 py-2" style="max-width: 500px; word-wrap: break-word; white-space: pre-wrap;">{{ json_encode($service->attribute) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('api_services.edit', $service) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection