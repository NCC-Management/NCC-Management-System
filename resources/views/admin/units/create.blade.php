@extends('layouts.admin')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        Create NCC Unit
    </h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('units.store') }}">
        @csrf

        <!-- Unit Name -->
        <div class="mb-5">
            <label class="block font-semibold mb-2 text-gray-700">
                Unit Name
            </label>
            <input type="text"
                   name="unit_name"
                   value="{{ old('unit_name') }}"
                   class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-green-500 focus:outline-none"
                   placeholder="Enter Unit Name"
                   required>
        </div>

        <!-- Battalion -->
        <div class="mb-5">
            <label class="block font-semibold mb-2 text-gray-700">
                Battalion
            </label>
            <input type="text"
                   name="battalion"
                   value="{{ old('battalion') }}"
                   class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-green-500 focus:outline-none"
                   placeholder="Enter Battalion Name"
                   required>
        </div>

        <!-- State -->
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-700">
                State
            </label>
            <input type="text"
                   name="state"
                   value="{{ old('state') }}"
                   class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-green-500 focus:outline-none"
                   placeholder="Enter State"
                   required>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center">
            <a href="{{ route('units.index') }}"
               class="text-gray-600 hover:text-gray-900">
                ← Back
            </a>

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
                Save Unit
            </button>
        </div>

    </form>

</div>

@endsection