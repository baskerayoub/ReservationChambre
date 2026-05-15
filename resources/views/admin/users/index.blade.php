@extends('layouts.app')
@section('title', 'Manage Users')
@section('hide_footer', true)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Manage Users</h1>
        <div class="flex gap-2">
            @foreach(['' => 'All', 'client' => 'Clients', 'receptionist' => 'Receptionists', 'admin' => 'Admins'] as $val => $label)
            <a href="{{ route('admin.users', ['role' => $val]) }}" class="px-3 py-1.5 text-xs font-medium rounded-full transition-colors {{ request('role') === $val ? 'bg-amber-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reservations</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4 font-medium flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr($user->name,0,1)) }}</div>
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->reservations_count }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.role', $user) }}">@csrf @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-amber-500">
                                @foreach(['client','receptionist','admin'] as $r)<option value="{{ $r }}" {{ $user->role===$r?'selected':'' }}>{{ ucfirst($r) }}</option>@endforeach
                            </select>
                        </form>
                        @else<span class="px-2 py-1 bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs rounded-full font-medium">{{ ucfirst($user->role) }} (You)</span>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
