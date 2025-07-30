@extends('superadmin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('content')

    @if (session('success'))
        <div id="alert-success"
            class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative animate__animated animate__fadeInDown"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate__animated animate__fadeInDown"
            role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Slot: Konten Profil -->
            @component('components.riwayatsuperadmin-tabs')
            <div class="space-y-6">
                <!-- Profile Information Section -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                    <div class="max-w-xl">
                        @include('superadmin.profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password Update Section -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                    <div class="max-w-xl">
                        @include('superadmin.profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                    <div class="max-w-xl">
                        @include('superadmin.profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            @endcomponent
        </div>
    </div>
@endsection