@extends('layouts.dashboardmainadmin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">Data Admin</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <a class="btn btn-info add-new " href="{{route('dataadmin.store')}}" data-toggle="modal" data-target="#addadmin"><i
                    class="fa fa-plus"></i> Add New</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="55px">No.</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th width="260px"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=0;
                            @endphp
                            @foreach($dataadmin as $du)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$du->nama}}</td>
                                <td>{{$du->username}}</td>
                                <td>{{$du->password}}</td>
                                <td>
                                    <form action="{{route('delete-admin',$du->id_admin) }}" method="POST"> 
                                    <a href="#" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-toggle="modal" data-target="#updateadmin{{$du->id_admin}}"><i
                                            class="fas fa-edit"></i>Edit</a>
                                            @csrf
                                            @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1"><i
                                            class="fas fa-trash"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <span class="page-link">Sebelumnya</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Selanjutnya</a>
                </li>
            </ul></br>
        </nav>
    </div>
</div>

<!-- Modal Add Admin -->
<div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors') }}
            </div>
            @endif
            <div class="modal-body">
                <form method="POST" action="{{route('dataadmin.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="name">Nama</div>
                        <div class="value">
                            <input class="form-control bg-white border-1 small mr-4" type="text" name="nama">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Username</div>
                        <div class="value">
                            <input class="form-control bg-white border-1 small mr-4" type="text" name="username">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Password</div>
                        <div class="value">
                            <input class="form-control bg-white border-1 small mr-4" type="text" name="password">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Edit Admin -->
@foreach($dataadmin as $du)
<div class="modal fade" id="updateadmin{{$du->id_admin}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action={{ route('update-admin', $du->id_admin) }} id="editForm">
                    @method('PATCH')
                    @csrf
                    <div class="form-row">
                        <div class="name">Nama</div>
                        <div class="value">
                            <input class="form-control bg-white border-1 small mr-4" type="text" name="nama" id="nama" value="{{$du->nama}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Username</div>
                        <div class="value">
                            <input class="form-control bg-white border-1 small mr-4" type="text" name="username" id="username" value="{{$du->username}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Password</div>
                        <div class="value">
                            <input class="form-control bg-white border-1 small mr-4" type="text" name="password" id="password" value="{{$du->password}}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>
</div>
@endforeach
<!-- End Modal -->
@endsection