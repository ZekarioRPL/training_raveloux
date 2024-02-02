@extends('layouts.layout')

@section('content')
    <div class="">
        <section class="px-2 sm:px-4">
            <div class="card relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="card-header">
                    <div class="card-title">{{ isset($user) ? 'Edit' : 'Create' }} {{ $title }}</div>
                </div>
                <form action="{{ isset($user) ? Route('user.update', $user->id) : Route('user.store') }}" method="post">
                    <div class="card-body flex flex-col space-y-3 md:flex">
                        <div>
                            <label for="email">Email</label>
                            <input type="email" class="input-form @error('email') border-red-700 @enderror" name="email"
                                id="email" value="{{ old('email', $user->email ?? '') }}">
                            @error('email')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password">password</label>
                            <input type="password" class="input-form @error('password') border-red-700 @enderror"
                                name="password" id="password" value="{{ old('password', $user->password ?? '') }}">
                            @error('password')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="first_name">First Name</label>
                            <input type="text" class="input-form @error('first_name') border-red-700 @enderror"
                                name="first_name" id="first_name" value="{{ old('first_name', $user->first_name ?? '') }}">
                            @error('first_name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name">Last Name</label>
                            <input type="text" class="input-form @error('last_name') border-red-700 @enderror"
                                name="last_name" id="last_name" value="{{ old('last_name', $user->last_name ?? '') }}">
                            @error('last_name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="address">Address</label>
                            <input type="text" class="input-form @error('address') border-red-700 @enderror"
                                name="address" id="address" value="{{ old('address', $user->address ?? '') }}">
                            @error('address')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone_number">Phone</label>
                            <input type="text" class="input-form @error('phone_number') border-red-700 @enderror"
                                name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $user->phone_number ?? '') }}">
                            @error('phone_number')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="role_id">Role</label>
                            <select id="role_id" name="role_id"
                                class="input-form @error('role_id') border-red-700 @enderror">
                                @foreach ($roles as $role)
                                    @if ($role === old('role', $user->role ?? null))
                                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                    @endif
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        @csrf
                        @isset($user)
                            @method('put')
                        @endisset
                        <button class="btn bg-blue-600">Save</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $('#sidebar-users').addClass('active')
    </script>
@endsection
