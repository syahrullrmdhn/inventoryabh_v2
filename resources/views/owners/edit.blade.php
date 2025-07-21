@extends('layouts.app')
@section('title','Edit Owner')
@section('content')
<div class="max-w-xl mx-auto">
  <div class="bg-gray-800/60 rounded-2xl p-8 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-white">Edit Owner</h2>
    <form action="{{ route('owners.update', $owner) }}" method="POST" class="space-y-5">
      @csrf @method('PUT')
      <div>
        <label class="block mb-1 text-gray-300">Name</label>
        <input name="name" value="{{ old('name', $owner->name) }}"
               class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700" required />
        @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block mb-1 text-gray-300">Contact</label>
        <input name="contact" value="{{ old('contact', $owner->contact) }}"
               class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700" />
        @error('contact')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
      </div>
      <div class="pt-4 flex gap-3">
        <button type="submit"
          class="py-2 px-6 bg-blue-600 rounded-lg text-white font-semibold hover:bg-blue-700 transition">
          Update
        </button>
        <a href="{{ route('owners.index') }}"
           class="py-2 px-6 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600 transition">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
