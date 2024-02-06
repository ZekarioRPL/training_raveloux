@extends('layouts.layout')

@section('content')
    <div>
        <section>
            <div class="mb-4">
                <div class="flex">
                    @if (auth()->user()->can('create-task'))
                        <a href="{{ Route('task.create') }}"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-400 border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-green-600 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-200 "
                            type="button" id="btnInsert">
                            Create Tasks
                        </a>
                    @endif
                </div>
            </div>
            <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <h2 class="card-title">Tasks List</h2>
                </div>
                <table id="table-data-task" class="table" cellspacing="0" width="100%"></table>
            </div>
        </section>
    </div>
@endsection

@section('style')
    <!-- Datatable Custom Style -->
    @vite('resources/css/externals/table/dataTable.css')
@endsection


@section('script')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#table-data-task').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {}
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        title: 'No',
                        caldendarable: false,
                        orderable: false,
                    },
                    {
                        data: 'title',
                        name: 'title',
                        title: 'Title',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'contact_name',
                        name: 'contact_name',
                        title: 'Client',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        title: 'Responsible',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'project_name',
                        name: 'project_name',
                        title: 'Project',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'status',
                        title: 'status',
                        caldendarable: false,
                        orderable: false,
                        exportable: false,
                    },
                    {
                        data: 'action',
                        title: 'action',
                        caldendarable: false,
                        orderable: false,
                        exportable: false,
                    },

                ]
            });
            $('#sidebar-tasks').addClass('active')
        });
    </script>
@endsection
