@php
$role = auth()->user()->role;
$masterLayout = 'layouts.dashboardsurveiyor';
@endphp

@if ($role == 'mainadmin')
  @php
    $masterLayout = 'layouts.dashboardmainadmin';
  @endphp
@elseif ($role == 'admin')
  @php
    $masterLayout = 'layouts.dashboardadmin';
  @endphp
@elseif ($role == 'surveiyor')
  @php
    $masterLayout = 'layouts.dashboardsurveiyor';
  @endphp
@else
  @php
    $masterLayout = 'layouts.dashboardsurveiyor';
  @endphp
@endif
@extends($masterLayout)

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Detail Pelaksanaan</h1>
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

      <form action="{{ route('pelaksanaan.update', $pelaksanaan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="card-body">
          <div class="form-row">
            <div class="name">Bulan - Tahun</div>
            <div class="value">
              <input pattern="\d{1,2}-\d{4}" class="form-control bg-white border-1 small mr-4" type="text" name="bulan_tahun" id="input-month"
                value="{{ $pelaksanaan->bulan_tahun }}">
            </div>
          </div>

          <div class="form-row">
            <div class="name">Jenis Kegiatan</div>
            <div class="value">
              <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jenis_kegiatan">
                <option value="">-Pilih-</option>
                @foreach ($jeniskegiatan as $jenis)
                  <option {{ $pelaksanaan->jenis_kegiatan == $jenis->namakegiatan ? 'selected' : '' }} value="{{ $jenis->namakegiatan }}">
                    {{ $jenis->namakegiatan }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="name">No. Sprint</div>
            <div class="value">
              <input value="{{ $pelaksanaan->no_sprint }}" class="form-control bg-white border-1 small mr-4" type="number" name="no_sprint">
            </div>
          </div>
          <div class="form-row">
            <div class="name">Waktu</div>
            <div class="value">
              <input value="{{ $pelaksanaan->waktu }}" class="form-control bg-white border-1 small mr-4" type="time" name="waktu">
            </div>
          </div>
          <div class="form-row">
            <div class="name">Personal</div>
            <div class="value">
              <input value="{{ $pelaksanaan->personal }}" class="form-control bg-white border-1 small mr-4" type="text" name="personal" readonly>
            </div>
            <div class="form-row">
              <div class="name">Outcome</div>
              <div class="value">
                <input value="{{ $pelaksanaan->outcome }}" id="outcome" type="hidden" name="outcome">
                <trix-editor input="outcome"></trix-editor>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="name">status_id</div>
            <div class="value">
              <select class="form-control" name="status_id">
                <option value="2" {{ old('status_id', $pelaksanaan->status_id) == 2 ? 'selected' : '' }}>Belum Terlaksana</option>
                <option value="1" {{ old('status_id', $pelaksanaan->status_id) == 1 ? 'selected' : '' }}>Terlaksana</option>
              </select>
            </div>
          </div>
          <div class="card-footer text-right">
            <a class="btn btn-secondary" href="{{ route('pelaksanaan.index') }}">Cancel</a>
            <button class="btn btn-primary" type="submit">Submit</button>
          </div>
      </form>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">
        <h4 class="card-title m-0">File Pelaksanaan</h4>
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
              @foreach ($pelaksanaan->filePelaksanaan as $key => $file)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $file->nama_file }}</td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary"
                      href="{{ asset('file/pelaksanaan/' . $pelaksanaan->id . '/file_pelaksanaan/' . $file->nama_file) }}" target="_blank">
                      Download
                    </a>
                    <form method="POST" style="display: inline" action="{{ route('pelaksanaan.removefile', $pelaksanaan->id) }}">
                      @csrf
                      <input type="hidden" value="file_pelaksanaan" name="type">
                      <input type="hidden" name="id_file" value="{{ $file->id }}">
                      <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <form action="{{ route('pelaksanaan.addfile', $pelaksanaan->id) }}" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="file_pelaksanaan" name="type">
          @csrf
          <div class="form-row">
            <div class="name">Add new file</div>
            <div class="value">
              <div class="input-group js-input-file">
                <input type="file" id="file" class="form-control" name="file" multiple="true">
                <button type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">Upload</button>
              </div>
              <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                file size 50 MB</div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">
        <h4 class="card-title m-0">File Laporan</h4>
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
              @foreach ($pelaksanaan->fileLaporan as $key => $file)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $file->nama_file }}</td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ asset('file/pelaksanaan/' . $pelaksanaan->id . '/file_laporan/' . $file->nama_file) }}"
                      target="_blank">
                      Download
                    </a>
                    <form method="POST" style="display: inline" action="{{ route('pelaksanaan.removefile', $pelaksanaan->id) }}">
                      @csrf
                      <input type="hidden" value="file_laporan" name="type">
                      <input type="hidden" name="id_file" value="{{ $file->id }}">
                      <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <form action="{{ route('pelaksanaan.addfile', $pelaksanaan->id) }}" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="file_laporan" name="type">
          @csrf
          <div class="form-row">
            <div class="name">Add new file</div>
            <div class="value">
              <div class="input-group js-input-file">
                <input type="file" id="file" class="form-control" name="file" multiple="true">
                <button type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">Upload</button>
              </div>
              <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                file size 50 MB</div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">
        <h4 class="card-title m-0">File Perwaktu</h4>
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
              @foreach ($pelaksanaan->filePerwaktu as $key => $file)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $file->nama_file }}</td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ asset('file/pelaksanaan/' . $pelaksanaan->id . '/file_perwaktu/' . $file->nama_file) }}"
                      target="_blank">
                      Download
                    </a>
                    <form method="POST" style="display: inline" action="{{ route('pelaksanaan.removefile', $pelaksanaan->id) }}">
                      @csrf
                      <input type="hidden" value="file_perwaktu" name="type">
                      <input type="hidden" name="id_file" value="{{ $file->id }}">
                      <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <form action="{{ route('pelaksanaan.addfile', $pelaksanaan->id) }}" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="file_perwaktu" name="type">
          @csrf
          <div class="form-row">
            <div class="name">Add new file</div>
            <div class="value">
              <div class="input-group js-input-file">
                <input type="file" id="file" class="form-control" name="file" multiple="true">
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
      $("#input-month").datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
      });
    });
  </script>
@endpush
