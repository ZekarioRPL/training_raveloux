@extends('layouts.layout')

@section('content')
    <div>
        <section>
            <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <h2 class="card-title">Dashboard</h2>
                </div>

            </div>
            {{-- <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
                <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                    <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        <h2 class="card-title">Dashboard</h2>
                    </div>
                </div>
                <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                    <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        <h2 class="card-title">Dashboard</h2>
                    </div>
                </div>
                <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                    <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        <h2 class="card-title">Dashboard</h2>
                    </div>
                </div>
                <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                    <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        <h2 class="card-title">Dashboard</h2>
                    </div>
                </div>
            </div> --}}

            <div class="relative mt-5 p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="p-4 bg-white rounded-lg md:p-8" id="stats" role="tabpanel"
                    aria-labelledby="stats-tab">
                    <dl
                        class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-2 xl:grid-cols-4 sm:p-8">
                        <div class="flex flex-col items-center justify-center">
                            <dt class="mb-2 text-3xl font-extrabold">{{ $count_clients }}</dt>
                            <dd class="text-gray-500 text-lg">Clients</dd>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <dt class="mb-2 text-3xl font-extrabold">{{ $count_projects }}</dt>
                            <dd class="text-gray-500 text-lg">Projects</dd>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <dt class="mb-2 text-3xl font-extrabold">{{ $count_tasks }}</dt>
                            <dd class="text-gray-500 text-lg">Tasks</dd>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <dt class="mb-2 text-3xl font-extrabold">{{ $count_not_done_projects }}</dt>
                            <dd class="text-gray-500 text-lg text-center">Project Not Done</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('style')
    <!-- Datatable Custom Style -->
    @vite('resources/css/externals/elements/table/dataTable.css')
@endsection

@section('script')
    <script>
        $('#sidebar-dashboard').addClass('active')
    </script>
@endsection
