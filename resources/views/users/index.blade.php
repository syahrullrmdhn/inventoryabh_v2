@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="ml-64 p-8 min-h-screen bg-gray-900">
  <div class="max-w-4xl mx-auto">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">User Management</h2>
        <p class="text-gray-400 mt-1">Manage system users and their access permissions</p>
      </div>
      <a href="{{ route('users.create') }}"
         class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-md hover:shadow-blue-500/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Add User
      </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-900/30 text-green-400 rounded-lg border border-green-800/50">
      {{ session('success') }}
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
          <thead class="bg-gray-700">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-gray-800 divide-y divide-gray-700">
            @foreach($users as $u)
            <tr class="hover:bg-gray-700/40 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="text-sm font-medium text-white">{{ $u->name }}</div>
                  @if(auth()->id() == $u->id)
                  <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-900/30 text-blue-400">You</span>
                  @endif
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-300">{{ $u->email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end space-x-2">
                  <a href="{{ route('users.edit', $u) }}"
                     class="inline-flex items-center px-3 py-1 border border-blue-600 rounded-md text-blue-400 hover:bg-blue-900/30 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                  </a>
                  @if(auth()->id() != $u->id)
                  <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-1 border border-red-600 rounded-md text-red-400 hover:bg-red-900/30 hover:text-white transition-colors"
                            onclick="return confirm('Are you sure you want to delete this user?')">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                      </svg>
                      Delete
                    </button>
                  </form>
                  @endif
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="text-sm text-gray-400">
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
      </div>
      <div class="bg-gray-800 rounded-lg border border-gray-700">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
