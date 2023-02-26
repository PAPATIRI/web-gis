@extends('layouts.app')

@section('styles')
    {{-- Load style css untuk tampilan datatables --}}
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">{{ $title }}

                        {{-- Route resource untuk membuat category / menampilkan form create category --}}
                        <a href="{{ route('category.create') }}" class="btn btn-info btn-sm float-end">Add</a>

                    </div>
                    <div class="card-body">

                        {{-- menampilkan session message ketika sukses maupun error --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fa fa-check"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <table class="table-bordered table-striped table" id="dataCategory">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                    {{-- form disini digunakan untuk menjalankan proses delete yang di jalankan saat klik tombol
                   delete di view action.blade --}}
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Hapus" style="display: none">
                </form>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    {{-- load jquery untuk datatables dan bootstrap --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        // ajax datatables yang di proses secara server side dimana kita akan meload nama kategori dan 2 tombol action
        // yaitu edit dan delete

        $(function() {
            $('#dataCategory').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                ajax: '{{ route('data-category') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'action'
                    }
                ]
            })
        })
    </script>
@endpush
