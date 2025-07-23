@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                <div class="max-w-xl">
                    @include('portal.profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                <div class="max-w-xl">
                    @include('portal.profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                <div class="max-w-xl">
                    @include('portal.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
