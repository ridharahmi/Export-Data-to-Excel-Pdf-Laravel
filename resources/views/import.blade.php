@extends('layouts.app')

@section('title','Import Users')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mt-3 mb-3">
                    @include('message.alert-message')
                </div>

                <div class="card bg-light mt-3">
                        <div class="card-header">
                            Import Export Excel
                        </div>
                    <div class="card-body">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control mb-3">
                            <button class="btn btn-success">Import User Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
