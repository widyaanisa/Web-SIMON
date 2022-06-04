@extends('layouts.dashboarduser')
@php
$user = auth()->user();
@endphp
@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Profil</h1>
    </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if (session('errors'))
      <div class="alert alert-danger">
        {!! implode('', $errors->all('<div>:message</div>')) !!}
      </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row" style="height:100%">
            <div class="col-md-3">
              <div class="profile-img">
                <img class="rounded-circle mt-3" src="{{ asset('uploads/' . $user->username . '.jpg') }}" alt="" />
              </div>
              <input type="file" name="image" class="form-control mt-1" placeholder="Pilih gambar">
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label for=username>Username</label>
                <input pattern ="[A-Za-z0-9]+" type="text" class="form-control" name="username" value="{{ $user->username }}">
              </div>
              <div class="form-group">
                <label for=fullName>Nama Pengguna</label>
                <input pattern="[a-zA-Z'-'\s]*" type="text" class="form-control" name="nama_pengguna" value="{{ $user->nama_pengguna }}">
              </div>
              <div class="form-group">
                <label for=Pangkat>Pangkat</label>
                <input pattern="[A-Za-z]{1,32}" type="text" class="form-control" name="pangkat" value="{{ $user->pangkat }}">
              </div>
              <div class="form-group">
                <label for=nrp>NRP</label>
                <input  pattern= "[0-9]{1,15}" type="text" class="form-control" name="NRP" value="{{ $user->NRP }}">
              </div>
              <div class="form-group">
                <label for=jabatan>Jabatan</label>
                <input pattern="[a-zA-Z'-'\s]*" type="text" class="form-control" name="jabatan" value="{{ $user->jabatan }}">
              </div>
              <div class="form-group ">
                <label for=tempatlahir>Tempat Lahir</label>
                <input pattern="[A-Za-z]{1,32}" type="text" class="form-control" name="tempatlahir" value="{{ $user->tempatlahir }}">
              </div>
              <div class="form-group ">
                <label for=tanggallahir>Tanggal Lahir</label>
                <input  pattern="\d{1,2}/\d{1,2}/\d{4}" type="date" class="form-control" name="tanggallahir" value="{{ $user->tanggallahir }}">
              </div>
              <div class="form-group">
                <label for=jeniskelamin>Jenis Kelamin</label>
                <select name="jeniskelamin" class="form-control">
                  <option value="">--Pilih--</option>
                  <option {{ $user->jeniskelamin == 'laki-laki' ? 'selected' : '' }} value="laki-laki">Laki-laki</option>
                  <option {{ $user->jeniskelamin == 'perempuan' ? 'selected' : '' }} value="perempuan">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label for=agama>Agama</label>
                <input  pattern="[A-Za-z]{1,32}" type="text" class="form-control" name="agama" value="{{ $user->agama }}">
              </div>
              <div class="form-group">
                <label for=email>Email</label>
                <input  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" type="email" class="form-control" name="email" value="{{ $user->email }}">
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
@endsection
