@extends('layouts.admin')

@section('content')
<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">Add Cadet</h2>

    <form method="POST" action="{{ route('cadets.store') }}">
        @csrf

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Enrollment No</label>
            <input type="text" name="enrollment_no" class="w-full border p-2 rounded" required>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Save Cadet
        </button>

    </form>

</div>
@endsection