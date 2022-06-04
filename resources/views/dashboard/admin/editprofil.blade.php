@extends('layouts.dashboardadmin')

@section('content')
<div class="container-fluid">

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Edit Profile Admin</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="/profiladmin"><i
                        class="fas fa-user fa-sm fa-fw mr-2"></i>Profile</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row" style="height:100%">
            <div class="col-md-3">
                <div class="profile-img">
                    <img class="rounded-circle mt-3" src="../img/photoprofil.jpg" alt=""/>
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="file"/>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="container">
                    <form>
                        <div class="form-group">
                            <label for=fullName>Nama</label>
                            <input type="text" class="form-control" id="name" value="Azmi">
                        </div>
                        <div class="form-group">
                            <label for=username>Username</label>
                            <input type="username" class="form-control" id="username" value="admin1">
                        </div>
                        <div class="row mt-3 mb-3">

                            <div class="col">
                                <button type="button" class="btn btn-primary btn-block">Save
                                    Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection