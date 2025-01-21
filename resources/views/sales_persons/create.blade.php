@extends('layout.admin-layout')

@section('main')
<div class="w-full px-4 py-6">
    <div class="mb-6 flex items-center space-x-4">
        <a href="{{ route('sales_persons.index') }}" class="text-blue-500 hover:underline text-sm">&larr; Back</a>
        <h1 class="text-xl font-bold text-gray-800">Create Sales</h1>
    </div>

    <div class="w-full max-w-xl mx-auto bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('sales_persons.store') }}" method="POST">
            @csrf
            @include('sales_persons.form')

            <div class="mt-4 flex justify-end">
                <button
                    type="submit"
                    class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600"
                >
                    Save Sales
                </button>
            </div>
        </form>
    </div>
</div>

@endsection