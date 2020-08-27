@extends('layouts.app')

@section('title','List Users')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mt-3 mb-3">
                    @include('message.alert-message')
                </div>
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-users"></i>
                        {{ __('List Users') }}
                    </div>

                    <div class="card-body">
                        <a class="btn btn-primary mb-3" href="{{ route('export-csv') }}"><i class="fa fa-file-excel-o"></i>
                            Export Excel</a>
                        <a class="btn btn-primary mb-3" href="{{ route('export-pdf') }}"><i class="fa fa-file-pdf-o"></i>
                            Export PDF</a>
                        <a class="btn btn-success mb-3" href="{{ route('importExportView') }}"><i
                                    class="fa fa-upload"></i> Import Excel</a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><a href="" class="btn btn-outline-info" data-toggle="modal"
                                           data-target="#user{{ $user->id }}"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                <div class="modal fade" id="user{{ $user->id }}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Information <b>{{ $user->name }}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>Name : </strong>
                                                        {{ $user->name }}
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Email : </strong>
                                                        {{ $user->email }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-danger"
                                                        data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-outline-primary">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No users</p>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
