@extends('layouts.layout')

@section('content')
    <div class="">
        <section class="px-2 sm:px-4">
            <div class="card relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="card-header">
                    <div class="card-title">{{ isset($project) ? 'Edit' : 'Create' }} {{ $title }}</div>
                </div>
                <form action="{{ isset($project) ? Route('project.update', $project->id) : Route('project.store') }}"
                    method="post">
                    <div class="card-body flex flex-col space-y-3 md:flex">
                        <div>
                            <label for="title">Title</label>
                            <input type="text" class="input-form @error('title') border-red-700 @enderror" name="title"
                                id="title" value="{{ old('title', $project->title ?? '') }}">
                            @error('title')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="description">Description</label>
                            <textarea class="input-form h-[5rem]  @error('description') border-red-500 @enderror" name="description"
                                id="description" placeholder="" value="{{ old('name', $project->description ?? '') }}">{{ old('description', $project->description ?? '') }}</textarea>
                            @error('description')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="deadline">Deadline</label>
                            <input type="date" class="input-form @error('deadline') border-red-700 @enderror"
                                name="deadline" id="deadline" value="{{ old('deadline', $project->deadline ?? '') }}">
                            @error('deadline')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="user_id">Assigned User</label>
                            <select id="user_id" name="user_id"
                                class="input-form @error('user_id') border-red-700 @enderror"
                                value="{{ old('user_id', $project->user_id ?? null) }}">
                                @foreach ($users as $user)
                                    @if ($user->id === old('user_id', $project->user_id ?? null))
                                        <option value="{{ $user->id }}" selected>{{ $user->user_full_name }}</option>
                                    @endif
                                    <option value="{{ $user->id }}">{{ $user->user_full_name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="client_id">Assigned Client</label>
                            <select id="client_id" name="client_id"
                                class="input-form @error('client_id') border-red-700 @enderror"
                                value="{{ old('client_id', $project->client_id ?? null) }}">
                                @foreach ($clients as $client)
                                    @if ($client->id === old('client_id', $project->client_id ?? null))
                                        <option value="{{ $client->id }}" selected>{{ $client->contact_name }}</option>
                                    @endif
                                    <option value="{{ $client->id }}">{{ $client->contact_name }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <select id="status" name="status"
                                class="input-form @error('status') border-red-700 @enderror">
                                @foreach ($statuses as $status)
                                    @if ($status === old('status', $project->status ?? null))
                                        <option value="{{ $status}}" selected>{{ $status }}</option>
                                    @endif
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        @csrf
                        @isset($project)
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
        $('#sidebar-projects').addClass('active')
    </script>
@endsection