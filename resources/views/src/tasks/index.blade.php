@extends('layouts.layout')

@section('content')
    <div>
        <section>
            <div class="mb-4">
                <div class="flex">
                    @if (auth()->user()->can('create-task'))
                        <a href="{{ Route('task.create') }}"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-400 border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-green-600 "
                            type="button">
                            Create Tasks
                        </a>
                    @endif
                </div>
            </div>
            <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <h2 class="card-title">Tasks List</h2>
                </div>

                {{-- FILTER DEADLINE --}}
                <div class="mb-5">
                    <div class="flex items-center">
                        <div class="relative w-full md:w-[12rem]">
                            <label for="filterStart">From</label>
                            <input type="date" class="input-form @error('filterStart') border-red-700 @enderror"
                                name="filterStart" id="filterStart" value="{{ old('filterStart') }}">
                            @error('deadline')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <span class="mx-5 mt-5 text-gray-900">-</span>
                        <div class="relative w-full md:w-[12rem]">
                            <label for="filterEnd">To</label>
                            <input type="date" class="input-form @error('filterEnd') border-red-700 @enderror"
                                name="filterEnd" id="filterEnd" value="{{ old('filterEnd') }}">
                            @error('deadline')
                                <p class="invalid-message text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- FILTER --}}
                <div class="grid grid-cols-1 gap-4 mb-5 md:grid-cols-4">
                    <div>
                        <label for="filterStatus">Status</label>
                        <select id="filterStatus" name="filterStatus"
                            class="input-form @error('filterStatus') border-red-700 @enderror">
                            <option value=""></option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" class="capitalize">{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('filterStatus')
                            <p class="invalid-message text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- BUTTON --}}
                <div
                    class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <button class="btn bg-blue-600" type="button" id="btnApplyFilter">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
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
                    data: function(d) {
                        d.filterStart = $('#filterStart').val(),
                            d.filterEnd = $('#filterEnd').val(),
                            d.filterStatus = $('#filterStatus').val()
                    }
                },
                createdRow: function(row, data, dataIndex) {

                    let now = new Date();
                    var deadline = Date.parse(data['deadline'])
                    var dateAlert = Date.parse(getDateTime())

                    if (deadline >= dateAlert && data['status'] != 'done') {
                        $(row).addClass('bg-red-100');
                    }
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
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) +
                                    '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'contact_name',
                        name: 'contact_name',
                        title: 'Client',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) +
                                    '...')) :
                                data : '-';
                        },
                    },
                    @if (auth()->user()->hasRole('admin'))
                        {
                            data: 'user_name',
                            name: 'user_name',
                            title: 'Responsible',
                            render: function(data, type, row) {
                                return data ? (data?.length > 40) ? ((data.substr(0, 40) +
                                        '...')) :
                                    data : '-';
                            },
                        },
                    @endif {
                        data: 'project_name',
                        name: 'project_name',
                        title: 'Project',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) +
                                    '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                        title: 'Deadline',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) +
                                    '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'btnStatus',
                        title: 'Status',
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

            // BUTTON FILTER
            $('#btnApplyFilter').click(function(e) {
                table.draw();
                console.log([
                    $('#filterStart').val(),
                    $('#filterEnd').val(),
                ]);
            })

            // SIDEBAR ACTIVE
            $('#sidebar-tasks').addClass('active')
        });
    </script>

    {{-- SELECT 2 --}}
    <script>
        $('#filterStatus').select2({
            placeholder: 'Select Status'
        });
    </script>

    <script>
        function getDateTime() {
            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate() - 3;

            if (month.toString().length == 1) {
                month = '0' + month;
            }
            if (day.toString().length == 1) {
                day = '0' + day;
            }
            var dateTime = year + '-' + month + '-' + day;
            return dateTime;
        }
    </script>
@endsection
