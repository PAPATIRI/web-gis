@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>

                    <div class="card-body">
                        {{-- action form yang mengarah ke route store untuk proses simpan data --}}
                        <form action="{{ route('category.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-2 mt-2">
                                <label for="">Spot Category</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror">

                                {{-- feedback error ketika data tidak lengkap/tidak sesuai --}}
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
