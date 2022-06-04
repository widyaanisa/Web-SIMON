@extends('layouts.dashboardsurveiyor')

@section('content')

<div class="container-fluid">

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="/profiluser"><i
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
                        <label for=username>Username</label>
                        <input  type="text" class="form-control" id="username" value="rizali">
                    </div>
                    <div class="form-group">
                        <label for=fullName>Nama Pengguna</label>
                        <input type="text" class="form-control" id="fullName" value="RIZALI">
                    </div>
                    <div class="form-group">
                        <label for=Pangkat>Pangkat</label>
                        <input type="text" class="form-control" id="pangkat" value="BRIPDA">
                    </div>
                    <div class="form-group">
                        <label for=nrp>NRP</label>
                        <input type="text" class="form-control" id="nrp" value="98080085">
                    </div>
                    <div class="form-group">
                        <label for=jabatan>Jabatann</label>
                        <input type="text" class="form-control" id="jabatan" value="BRIGADIR DITINTELKAM POLDA KALSEL">
                    </div>
                    <div class="form-group ">
                        <label for=tempatlahir>Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempatlahir" value="Balikpapan">
                    </div>
                    <div class="form-group ">
                        <label for=tanggallahir>Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggallahir" value="1998-08-12">
                    </div>
                    <div class="form-group">
                        <label for=jeniskelamin>Jenis Kelamin</label>
                         <div class="value">
                            <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" id="jeniskelamin"
                                aria-label="select" >
                                <option value="pilih">-- Pilih Jenis Kelamin --</option>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for=agama>Agama</label>
                        <div class="value">
                            <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data"
                                aria-label="select" id="agama">
                                <option value="pilih">-- Pilih Agama --</option>
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="buddha">Buddha</option>
                                <option value="hindu">Hindu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for=email>Email</label>
                        <input type="email" class="form-control" id="email" value="rizali@gmail.com">
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