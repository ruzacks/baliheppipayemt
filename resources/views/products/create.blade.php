@extends('layout.admin-layout')

@section('main')
<div class="w-full px-4 py-6">
    <h1 class="mb-6 text-xl font-bold text-gray-800">Create Product</h1>
    <div class="max-w-xl mx-auto bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            @include('products.form')
            <div class="mt-4 text-right">
                <button
                    type="submit"
                    class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600"
                >
                    Save Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
