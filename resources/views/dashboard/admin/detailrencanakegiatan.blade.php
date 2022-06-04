@extends('layouts.dashboardadmin')

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Rencana Kegiatan</h1>
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

    <div class="card shadow mb-4">
      <div class="card-header">
        <h4 class="card-title m-0">Detail</h4>
      </div>

      <form action="{{ route('admin.rencanakegiatan.update') }}" method="POST" enctype="multipart/form-data">
        <div class="card-body">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="edit-rk-id" value="{{ $rencana->id_rencana }}">
          <div class="form-row">
            <div class="name">Bulan - Tahun</div>
            <div class="value">
              <input pattern="\d{1,2}-\d{4}"  value="{{ $rencana->bulan_tahun }}" id="edit-rk-bulan" class="form-control bg-white border-1 small mr-4 input-month" type="text" name="bulan_tahun">
              <div class="invalid-feedback">
                Please choose a username.
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="name">Jenis Kegiatan</div>
            <div class="value">
              <select id="edit-rk-jenis" class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jeniskegiatan">
                <option value="">-Pilih-</option>
                @foreach ($jeniskegiatan as $jenis)
                  <option {{ $rencana->jeniskegiatan == $jenis->namakegiatan ? 'selected' : '' }} value="{{ $jenis->namakegiatan }}">
                    {{ $jenis->namakegiatan }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="name">Personal</div>
            <div class="value">
                <input value="{{ $rencana->personal }}"class="form-control bg-white border-1 small mr-4" type="text" name="personal" readonly>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="/rencanakegiatanadmin" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">
        <h4 class="card-title m-0">Files</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <th width="52px">No</th>
              <th>File Name</th>
              <th width="180px">Action</th>
            </thead>
            <tbody>
              @foreach ($rencana->fileRencanaKegiatan as $key => $file)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $file->nama_file }}</td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ asset('file/' . $file->nama_file) }}" target="_blank">
                      Download
                    </a>
                    <form method="POST" style="display: inline" action="{{ route('admin.rencanakegiatan.removefile', $rencana->id_rencana) }}">
                      @csrf
                      <input type="hidden" name="id_file" value="{{ $file->id }}" accept=".png, .jpg, .jpeg .pdf">
                      <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <form action="{{ route('admin.rencanakegiatan.addfile', $rencana->id_rencana) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="name">Add new file</div>
            <div class="value">
              <div class="input-group js-input-file">
                <input type="file" id="file" class="form-control" name="file" multiple="true" accept=".png, .jpg, .jpeg .pdf">
                <button type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">Upload</button>
              </div>
              <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                file size 50 MB</div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@push('js')
  <script>
    $(document).ready(function() {
      $(".input-month").datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
      });
    });
  </script>
@endpush
