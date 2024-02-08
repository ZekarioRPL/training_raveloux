@extends('layouts.layout')

@section('content')
    <div class="">
        <section class="px-2 sm:px-4">
            <div class="card relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="card-header">
                    <div class="card-title">Profile</div>
                </div>
                @if (session()->has('status'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                        <ul>
                            <li>{{ session()->get('status') }}</li>
                        </ul>
                    </div>
                @endif
                <form action="{{ Route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body flex flex-col space-y-3 md:flex">
                        <div>
                            <label for="email">Email</label>
                            <input type="email" class="input-form @error('email') border-red-700 @enderror" name="email"
                                id="email" value="{{ old('email', $profile->email ?? '') }}">
                            @error('email')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password">password</label>
                            <input type="password" class="input-form @error('password') border-red-700 @enderror"
                                name="password" id="password" value="{{ old('password') }}">
                            @error('password')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="first_name">First Name</label>
                            <input type="text" class="input-form @error('first_name') border-red-700 @enderror"
                                name="first_name" id="first_name"
                                value="{{ old('first_name', $profile->first_name ?? '') }}">
                            @error('first_name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name">Last Name</label>
                            <input type="text" class="input-form @error('last_name') border-red-700 @enderror"
                                name="last_name" id="last_name" value="{{ old('last_name', $profile->last_name ?? '') }}">
                            @error('last_name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="address">Address</label>
                            <input type="text" class="input-form @error('address') border-red-700 @enderror"
                                name="address" id="address" value="{{ old('address', $profile->address ?? '') }}">
                            @error('address')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone_number">Phone</label>
                            <input type="text" class="input-form @error('phone_number') border-red-700 @enderror"
                                name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                            @error('phone_number')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input">Upload file</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                id="file_input" name="file_input" type="file" value="{{ old('file_input') }}">
                            @if (isset($userRole))
                                <div class="mt-5">
                                    <img src="{{ $userRole->getFirstMediaUrl('user_media') ?? '' }}"
                                        alt="{{ $userRole->getFirstMedia('user_media')->file_name ?? '' }}"
                                        class="h-auto max-w-sm min-w-[300px] rounded-lg">
                                </div>
                            @endif
                            @error('file_input')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        @csrf
                        @method('put')
                        @if (auth()->user()->can('edit-profile'))
                            <button class="btn bg-blue-600">Save</button>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
