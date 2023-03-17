@extends('backend.layouts.master')
@section('container')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                {{-- <h4 class="page-title">{{ $title }}</h4> --}}
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">{{ $title  }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="reloadTable">  
                        <div class="card-header">
                            <h4 class="card-title">Daftar Toko Saya</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <a href="{{ route('toko.tambahToko') }}" class="btn btn-success btn-sm">
                                    <span class="btn-label"><i class="fas fa-plus"></i></span>
                                    Tambah Toko
                                </a>
                            </div>
                            <div class="table-responsive">
                                {{-- @csrf --}}
                                <table id="basic-datatables" class="table table-hover tabelToko" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Toko</th>
                                            <th>Status Toko</th>
                                            <th>Profile Toko</th>
                                            <th width="10px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($daftarTokoSaya as $item)   
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama_toko }}</td>
                                            <td>
                                                @if ($item->status_toko == 1)
                                                    <span class="badge badge-success">Buka</span>
                                                    @else
                                                    <span class="badge badge-danger">Tutup</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="avatar">
                                                    <img src="{{ url('uploads/Foto Sampul Toko/')}}/{{$item->sampul_toko }}" alt="..." class="avatar-img rounded">
                                                </div>
                                            </td>
                                            <td width="30px">
                                                <div class="form-button-action">
                                                    <a href="{{ url('detail-toko',$item->id) }}" type="button" data-toggle="tooltip" title="Detail Toko" class="btn btn-link btn-success" data-original-title="Edit Task" data-id="{{ $item->id }}" data-jenis="detail">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ url('ubah-toko',$item->id) }}" type="button" data-toggle="tooltip" title="Ubah Toko" class="btn btn-link btn-primary" data-original-title="Edit Task" data-id="{{ $item->id }}" data-jenis="Ubah">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    {{-- <button type="button" data-toggle="tooltip" title="Ubah Toko" class="btn btn-link btn-primary action" data-original-title="Edit Task" data-id="{{ $item->id }}" data-jenis="ubah">
                                                        <i class="fa fa-edit"></i>
                                                    </button> --}}
                                                    <button type="button" data-toggle="tooltip" title="Hapus Toko" class="btn btn-link btn-danger action" data-original-title="Remove" data-id="{{ $item->id }}" data-jenis="hapus">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.layouts.footer')
    <script>
        $(document).ready(function() { 
            $.getJSON('list-toko', function(data){
                // console.log(data);
            if(data == 0){
                alert();
            }
            function alert(){
                var content = {};
                var from ='top';
                var align = 'right';
                var state = 'warning';
                content.message = 'Anda belum memiliki toko, Silakan daftarkan toko anda terlebih dahulu.';
                content.title = 'Informasi..!';
                content.icon = 'fas fa-bell';
                $.notify(content,{
                                type: state,
                                placement: {
                                    from: from,
                                    align: align
                                },
                                time: 0.9,
                                delay: 0,
                            });
                }
            });
        })
    </script>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.tabelToko').on('click','.action',function(){
            let data    = $(this).data()
            let id      = data.id
            let jenis   = data.jenis

            if(jenis == 'detail'){
                // alert('Detail'+id)
            }
            else if( jenis == 'ubah'){
                alert('ubah'+id)
            }
            else{
                Swal.fire({
                    title: "Anda Yakin ?",
                    text: "Toko akan dihapus",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Batal",
                    confirmButtonText: "Hapus Data"
                }).then(result => {
                if (result.value) {
                    $.ajax({
                        method  : 'DELETE',
                        url     : `{{ url('hapus-toko') }}/${id}`,
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function(res){
                            Swal.fire({
                                    icon: res.state,
                                    title: res.title,
                                    text: res.message,
                                    }).then(function(){
                                        location.reload();
                                    })  

                        }
                    })
                }
            });
            return
            }

        })
    </script>
</div>
    	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
@endsection