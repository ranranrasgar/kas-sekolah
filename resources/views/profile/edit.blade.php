<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Kolom 2 -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl w-full">
                    <div class="flex items-center space-x-8"> <!-- space-x-8 memberikan jarak antar kolom -->
                        <!-- Kolom 1: Menampilkan foto profil -->
                        <div class="w-20 h-25">
                            <img src="{{ $user->profile_photo ? Storage::url($user->profile_photo) : asset('default-avatar.png') }}"
                                alt="Profile Photo" class="w-full h-full object-cover border-2 border-gray-300">
                        </div>

                        <!-- Kolom 2: Form Upload Foto -->
                        <div class="flex flex-col">
                            <form method="POST" action="{{ route('profile.update_photo') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="mt-4" id="profile_photo" name="profile_photo">
                                <x-primary-button class="mt-4">{{ __('Upload') }}</x-primary-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- Kolom kiri: Informasi Profil -->
                    <div class="flex-1">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </div>


                </div>
            </div>

            <!-- Bagian lain untuk Update Password, Delete User, dll -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
