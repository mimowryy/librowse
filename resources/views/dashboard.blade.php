<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div class="col-6 col-md-3">
    <a href="/admin/students" style="text-decoration:none">
        <div class="admin-stat">
            <div class="admin-stat-number" style="color:#0a7a4a">{{ $totalStudents }}</div>
            <div class="admin-stat-label">Students →</div>
        </div>
    </a>
</div>