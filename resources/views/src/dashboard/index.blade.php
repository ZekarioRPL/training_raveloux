@extends('layouts.layout')

@section('content')
    <div>
        <section>
            <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <h2 class="card-title">Dashboard</h2>
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
