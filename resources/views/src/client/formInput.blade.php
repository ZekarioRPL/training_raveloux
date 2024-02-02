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
                            <label for="name">Title</label>
                            <input type="text" class="input-form @error('name') border-red-700 @enderror" name="name"
                                id="name" value="{{ old('name', $client->contact_name ?? '') }}">
                            @error('name')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="description">Description</label>
                            <textarea class="input-form min-h-7  @error('description') border-red-500 @enderror" name="description" id="description"
                                placeholder="" value="{{ old('name', $client->contact_email ?? '') }}"></textarea>
                            @error('description')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        @csrf
                        @isset($client)
                            @method('put')
                        @endisset
                        <button class="btn ml-auto">Simpan</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
