@extends('layouts.layout')

@section('content')
    <div>
        <section>
            <div class="mb-4">
                <div class="flex">
                    @if (auth()->user()->can('create-client'))
                        <a href="{{ Route('client.create') }}"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-400 border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-green-600 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-200"
                            type="button" id="btnInsert">
                            <i data-feather="plus" width='20px'></i>
                            Create Clients
                        </a>
                    @endif
                </div>
            </div>
            <div class="relative p-4 overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <div class="flex flex-col items-center justify-between pb-5 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <h2 class="card-title">Clients List</h2>
                </div>
                <table id="table-data-client" class="table" cellspacing="0" width="100%"></table>
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
            let table = $('#table-data-client').DataTable({
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
                        data: 'company_name',
                        name: 'company_name',
                        title: 'Company',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'company_val',
                        name: 'company_val',
                        title: 'VAT',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'company_address',
                        name: 'company_address',
                        title: 'Address',
                        render: function(data, type, row) {
                            return data ? (data?.length > 40) ? ((data.substr(0, 40) + '...')) :
                                data : '-';
                        },
                    },
                    {
                        data: 'action',
                        title: 'action',
                        caldendarable: false,
                        orderable: false,
                        exportable: false,
                        // footer: 'Id',
                    },

                ]
            });
            $('#sidebar-clients').addClass('active')
        });
    </script>
@endsection
