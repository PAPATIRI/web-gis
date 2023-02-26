@extends('layouts.app')

@section('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">{{ $title }}
                        <a href="{{ route('spot.create') }}" class="btn btn-info btn-sm float-end">Add</a>
                    </div>
                    {{-- sama seperti index pada category,pada index spot ini kita menambahkan style css untuk datatables
                    dan jquery untuk datatable dan bootstrap. Yang berbeda pada ajax routenya dan untuk index spot ini kita memanggil column data category
                    di bagian ajax server side datatable.Column category ini sudah kita definisikan di DataController pada method Spot --}}
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fa fa-check"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <table class="table-bordered table-striped table" id="dataSpot">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Spot Name</th>
                                    <th>Spot Category</th>
                                    <th>Opsi</th>
                                </tr>
                            <tbody>
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Hapus" style="display: none">
                </form>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $('#dataSpot').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                ajax: '{{ route('data-spot') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'action'
                    }
                ]
            })
        })
    </script>
@endpush
