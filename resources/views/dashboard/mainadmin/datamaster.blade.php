@extends('layouts.dashboardmainadmin')

@section('content')
  <div class="container-fluid">
    @php
      $printUrl = '/datamastermainadmin/export?' . explode('?', url()->full())[1];
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Data Master</h1>
      <a href="{{ $printUrl }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print fa-sm text-white-50 mr-2"></i>Download</a>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header">
        <form action="/datamastermainadmin" class="d-none d-sm-inline-block form-inline mr-auto navbar-search">
          <div class="input-group mb-2">
            <select onchange="this.form.submit()" name="data" type="text" class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data"
              aria-label="select">
              <option {{ $data == 'rencana' ? 'selected' : '' }} value="rencana">Data Rencana Kegiatan</option>
              <option {{ $data == 'pelaksanaan' ? 'selected' : '' }} value="pelaksanaan">Data Pelaksanaan</option>
            </select>

            <input type="text" name="search" class="form-control bg-white border-1 small" placeholder="Search for..." aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="card-body">
        @if ($data == 'rencana')
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="55px">No.</th>
                  <th width="140px">Bulan - Tahun</th>
                  <th>Jenis Kegiatan</th>
                  <th>Tentang</th>
                  <th>Personal</th>
                  <th width="160px">Action</th>
                </tr>
              </thead>

              @foreach ($rencanakegiatan as $rk)
                <tbody>
                  <tr>
                    <td scope="row">{{ $loop->iteration + ($rencanakegiatan->currentPage() - 1) * $rencanakegiatan->perPage() }}</td>
                    <td>{{ $rk->bulan_tahun }}</td>
                    <td>{{ $rk->jeniskegiatan }}</td>
                    <td>
                      @if ($rk->fileRencanaKegiatan)
                        @foreach ($rk->fileRencanaKegiatan as $file)
                          <a href="{{ asset('file/' . $file->nama_file) }}" target="_blank">
                            {{ $file->nama_file }}
                          </a> |
                        @endforeach
                      @endif
                      {{ $rk->tentang }}
                    </td>
                    <td>{{ $rk->personal }}</td>
                    <td>
                      <a href="{{ route('mainadmin.rencanakegiatan.detail', $rk->id_rencana) }}" class="btn btn-sm btn-outline-success mr-1 mb-1">
                        View
                      </a>
                      {{-- <a data-toggle="modal" data-target="#editrk" href="#" data-id="{{ $rk->id_rencana }}" data-bulan="{{ $rk->bulan_tahun }}"
                            data-jenis="{{ $rk->jeniskegiatan }}" data-personal="{{ $rk->personal }}"
                            class="btn btn-edit-rk btn-sm btn-outline-primary mr-1 mb-1"><i class="fas fa-edit"></i>Edit</a> --}}

                      {{-- <a href="#" class="btn btn-sm btn-outline-danger mr-1 mb-1"><i class="fas fa-trash"></i>Delete</a> --}}
                      <form method="POST" style="display: inline" action="{{ route('mainadmin.rencanakegiatan.delete') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $rk->id_rencana }}">
                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1">Delete</button>
                      </form>
                    </td>
                  </tr>
                </tbody>
              @endforeach
            </table>
            Halaman : {{ $rencanakegiatan->currentPage() }} <br />
            Jumlah Data : {{ $rencanakegiatan->total() }} <br />
            Data Per Halaman : {{ $rencanakegiatan->perPage() }} <br />
          </div>
          <div class="d-flex justify-content-center">
            {!! $rencanakegiatan->appends(['data' => 'rencana'])->links() !!}
          </div>
        @elseif ($data == 'pelaksanaan')
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="55px">No.</th>
                  <th width="140px">Bulan - Tahun</th>
                  <th width="140px">Jenis kegiatan</th>
                  <th width="100px">No. Sprint</th>
                  <th width="140px">Tentang</th>
                  <th width="110px">Waktu</th>
                  <th width="150px">Personal</th>
                  <th width="160px">Laporan Kegiatan</th>
                  <th width="160px">Perwaktu</th>
                  <th width="180px">Outcome</th>
                  <th width="260px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($daftarPelaksanaan as $key => $pel)
                  <tr>
                    <td>{{ ++$key + ($daftarPelaksanaan->currentPage() - 1) * $daftarPelaksanaan->perPage() }}</td>
                    <td>{{ $pel->bulan_tahun }}</td>
                    <td>{{ $pel->jenis_kegiatan }}</td>
                    <td>{{ $pel->no_sprint }}</td>
                    <td>
                      @if ($pel->filePelaksanaan)
                        @foreach ($pel->filePelaksanaan as $file)
                          <a href="{{ asset('file/pelaksanaan/' . $pel->id . '/file_pelaksanaan/' . $file->nama_file) }}" target="_blank">
                            {{ $file->nama_file }}
                          </a> |
                        @endforeach
                      @endif
                    </td>
                    <td>{{ $pel->waktu }}</td>
                    <td>{{ $pel->personal }}</td>
                    <td>
                      @if ($pel->fileLaporan)
                        @foreach ($pel->fileLaporan as $file)
                          <a href="{{ asset('file/pelaksanaan/' . $pel->id . '/file_laporan/' . $file->nama_file) }}" target="_blank">
                            {{ $file->nama_file }}
                          </a> |
                        @endforeach
                      @endif
                    </td>
                    <td>
                      @if ($pel->filePerwaktu)
                        @foreach ($pel->filePerwaktu as $file)
                          <a href="{{ asset('file/pelaksanaan/' . $pel->id . '/file_perwaktu/' . $file->nama_file) }}" target="_blank">
                            {{ $file->nama_file }}
                          </a> |
                        @endforeach
                      @endif
                    </td>
                    <td>-</td>
                    <td>
                      <a href="{{ route('pelaksanaan.show', $pel->id) }}" class="btn btn-sm btn-outline-success mr-1 mb-1">
                        View
                      </a>
                      <form method="POST" style="display: inline" action="{{ route('pelaksanaan.destroy', $pel->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $pel->id }}">
                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            Halaman : {{ $daftarPelaksanaan->currentPage() }} <br />
            Jumlah Data : {{ $daftarPelaksanaan->total() }} <br />
            Data Per Halaman : {{ $daftarPelaksanaan->perPage() }} <br />
          </div>
          <div class="d-flex justify-content-center">
            {!! $daftarPelaksanaan->links() !!}
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
