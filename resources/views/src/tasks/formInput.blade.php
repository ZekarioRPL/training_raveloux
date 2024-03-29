@extends('layouts.layout')

@section('content')
    <div class="">
        <section class="px-2 sm:px-4">
            <div class="card relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="card-header">
                    <div class="card-title">{{ isset($task) ? 'Edit' : 'Create' }} {{ $title }}</div>
                </div>
                @if (session()->has('status'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                        <ul>
                            <li>{{ session()->get('status') }}</li>
                        </ul>
                    </div>
                @endif
                <form action="{{ isset($task) ? Route('task.update', $task->id) : Route('task.store') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="card-body flex flex-col space-y-3 md:flex">
                        <div>
                            <label for="title">Title</label>
                            <input type="text" class="input-form @error('title') border-red-700 @enderror" name="title"
                                id="title" value="{{ old('title', $task->title ?? '') }}">
                            @error('title')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="description">Description</label>
                            <textarea class="input-form h-[5rem]  @error('description') border-red-500 @enderror" name="description"
                                id="description" placeholder="">{{ old('description', $task->description ?? '') }}</textarea>
                            @error('description')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="deadline">Deadline</label>
                            <input type="date" class="input-form @error('deadline') border-red-700 @enderror"
                                name="deadline" id="deadline" value="{{ old('deadline', $task->deadline ?? '') }}">
                            @error('deadline')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        @if (auth()->user()->hasRole('admin'))
                            <div>
                                <label for="user_id">Assigned User</label>
                                <select id="user_id" name="user_id"
                                    class="input-form  @error('user_id') border-red-700 @enderror"
                                    value="{{ old('user_id', $task->user_id ?? null) }}">
                                    @foreach ($users as $user)
                                        @if ($user->id === old('user_id', $task->user_id ?? null))
                                            <option value="{{ $user->id }}" selected>{{ $user->user_full_name }}
                                            </option>
                                        @else
                                            <option value="{{ $user->id }}">{{ $user->user_full_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="invalid-message text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                        <div>
                            <label for="client_id">Assigned Client</label>
                            <select id="client_id" name="client_id"
                                class="input-form @error('client_id') border-red-700 @enderror"
                                value="{{ old('client_id', $task->client_id ?? null) }}">
                                @foreach ($clients as $client)
                                    @if ($client->id === old('client_id', $task->client_id ?? null))
                                        <option value="{{ $client->id }}" selected>{{ $client->contact_name }}</option>
                                    @else
                                        <option value="{{ $client->id }}">{{ $client->contact_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="project_id">Assigned Project</label>
                            <select id="project_id" name="project_id"
                                class="input-form @error('project_id') border-red-700 @enderror"
                                value="{{ old('project_id', $task->project_id ?? null) }}">
                                @foreach ($projects as $project)
                                    @if ($project->id === old('project_id', $task->project_id ?? null))
                                        <option value="{{ $project->id }}" selected>{{ $project->title }}</option>
                                    @else
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('project_id')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <select id="status" name="status"
                                class="input-form @error('status') border-red-700 @enderror">
                                @foreach ($statuses as $status)
                                    @if ($status === old('status', $task->status ?? null))
                                        <option value="{{ $status }}" class="capitalize" selected>{{ $status }}</option>
                                    @else
                                        <option value="{{ $status }}" class="capitalize">{{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('status')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900"
                                for="file_input">Upload file</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                id="file_input" name="file_input" type="file" value="{{ old('file_input') }}">
                            @if (isset($task))
                                <div class="mt-5">
                                    <img src="{{ $task->getFirstMediaUrl('task_media') ?? '' }}"
                                        alt="{{ $task->getFirstMedia('task_media')->file_name ?? '' }}"
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
                        @isset($task)
                            @method('put')
                        @endisset
                        @if (auth()->user()->can('create-task') || auth()->user()->can('update-task'))
                            <button class="btn bg-blue-600">Save</button>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    {{-- <script src="{{ asset('/select2/users.js') }}"></script> --}}
    <script>
        $('#user_id').select2({
            placeholder: 'Select Users'
        });
        $('#client_id').select2({
            placeholder: 'Select Clients'
        });
        $('#project_id').select2({
            placeholder: 'Select Projects'
        });
        $('#sidebar-tasks').addClass('active')
    </script>
@endsection
