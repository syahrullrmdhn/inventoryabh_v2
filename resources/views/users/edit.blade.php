@extends('layouts.app')
@section('title','Edit User')
@section('content')
<div class="ml-64 p-8 min-h-screen bg-gradient-to-br from-gray-900 to-gray-800">
  <div class="max-w-lg mx-auto">
    <div class="bg-gray-800/60 rounded-xl shadow-lg p-8 mt-6">
      <h2 class="text-2xl font-bold text-white mb-6">Edit User</h2>
      <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
        @csrf @method('PUT')
        <div>
          <label class="block mb-1 text-gray-300">Name</label>
          <input name="name" value="{{ old('name', $user->name) }}"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700" required />
          @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="block mb-1 text-gray-300">Email</label>
          <input name="email" value="{{ old('email', $user->email) }}"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700" required />
          @error('email')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="block mb-1 text-gray-300">Password <span class="text-xs text-gray-400">(Kosongkan jika tidak ganti)</span></label>
          <input name="password" type="password"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700" />
          @error('password')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="block mb-1 text-gray-300">Confirm Password</label>
          <input name="password_confirmation" type="password"
                 class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700" />
        </div>
        <div class="flex gap-4 pt-2">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold">Update</button>
          <a href="{{ route('users.index') }}" class="bg-gray-700 text-gray-300 px-5 py-2 rounded-lg">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
