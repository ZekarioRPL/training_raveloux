@extends('layouts.layout')

@section('content')
    <div class="">
        <section class="px-2 sm:px-4">
            <div class="card relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="card-header">
                    <div class="card-title">{{ isset($client) ? 'Edit' : 'Create' }} {{ $title }}</div>
                </div>
                <form action="{{ isset($client) ? Route('client.update', $client->id) : Route('client.store') }}"
                    method="post">
                    <div class="card-body flex flex-col space-y-3 md:flex">
                        <div>
                            <label for="contact_name">Contact Name</label>
                            <input type="text" class="input-form @error('contact_name') border-red-700 @enderror" name="contact_name"
                                id="contact_name" value="{{ old('contact_name', $client->contact_name ?? '') }}">
                            @error('contact_name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_email">Contact Email</label>
                            <input type="email" class="input-form @error('contact_email') border-red-700 @enderror" name="contact_email"
                                id="contact_email" value="{{ old('contact_email', $client->contact_email ?? '') }}">
                            @error('contact_email')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_phone_number">Phone</label>
                            <input type="text" class="input-form @error('contact_phone_number') border-red-700 @enderror" name="contact_phone_number"
                                id="contact_phone_number" value="{{ old('contact_phone_number', $client->contact_phone_number ?? '') }}">
                            @error('contact_phone_number')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="company_name">Company Name</label>
                            <input type="text" class="input-form @error('company_name') border-red-700 @enderror" name="company_name"
                                id="company_name" value="{{ old('company_name', $client->company_name ?? '') }}">
                            @error('company_name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="company_address">Company Address</label>
                            <input type="text" class="input-form @error('company_address') border-red-700 @enderror" name="company_address"
                                id="company_address" value="{{ old('company_address', $client->company_address ?? '') }}">
                            @error('company_address')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="company_city">Company City</label>
                            <input type="text" class="input-form @error('company_city') border-red-700 @enderror" name="company_city"
                                id="company_city" value="{{ old('company_city', $client->company_city ?? '') }}">
                            @error('company_city')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="company_zip">Company Zip</label>
                            <input type="text" class="input-form @error('company_zip') border-red-700 @enderror" name="company_zip"
                                id="company_zip" value="{{ old('company_zip', $client->company_zip ?? '') }}">
                            @error('company_zip')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="company_val">Company Val</label>
                            <input type="number" class="input-form @error('company_val') border-red-700 @enderror" name="company_val"
                                id="company_val" value="{{ old('company_val', $client->company_val ?? '') }}">
                            @error('company_val')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- TEXT AREA --}}
                        {{-- <div>
                            <label for="description">Description</label>
                            <textarea class="input-form min-h-7  @error('description') border-red-500 @enderror" name="description" id="description"
                                placeholder="" value="{{ old('name', $client->contact_email ?? '') }}"></textarea>
                            @error('description')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="card-footer">
                        @csrf
                        @isset($client)
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
        $('#sidebar-clients').addClass('active')
    </script>
@endsection