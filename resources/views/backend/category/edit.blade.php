@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>

                    <div class="card-body">
                        {{-- form action yang mengarah ke route update untuk update data
                        untuk update data bisa menggunakan method put ataun patch
                        pastikan nama parameter yang di passing ke form edit sama dengan
                        parameter ynag berasal dari method edit pada controller  --}}
                        <form action="{{ route('category.update', $category) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-2 mt-2">
                                <label for="">Spot Category</label>
                                <input type="text" name="name" value="{{ $category->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
