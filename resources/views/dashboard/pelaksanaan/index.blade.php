@php
$role = auth()->user()->role;
$masterLayout = 'layouts.dashboarduser';
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
    $masterLayout = 'layouts.dashboarduser';
  @endphp
@endif
@extends($masterLayout)

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Pelaksanaan Kegiatan</h1>
    </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if (session('errors'))
      <div class="alert alert-danger">
        Data tidak valid, mohon melengkapi form dengan benar.
      </div>
    @endif

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        @if ($role != 'surveiyor')
          <a class="btn btn-info add-new " href="#" data-toggle="modal" data-target="#formdatapelaksanaanModal"><i class="fa fa-plus"></i> Add New</a>
        @endif
        @if ($role == 'mainadmin' || $role == 'admin')
          <form action="/pelaksanaan/export" method="post">
            @csrf
            <button class="btn btn-info" type="submit"><i class="fa fa-download"></i> Export</button>
          </form>
        @endif
      </div>
      <div class="card-body">
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
                @if (auth()->user()->role != 'surveiyor' && auth()->user()->role != 'user')
                  <th width="260px">Aksi</th>
                @endif
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
                  <td>{{ $pel->outcome }}</td>
                  @if (auth()->user()->role != 'surveiyor')
                    <td>
                      <a href="{{ route('pelaksanaan.show', $pel->id) }}" class="btn btn-sm btn-outline-success mr-1 mb-1">
                        View
                      </a>
                      <form method="POST" style="display: inline" action="{{ route('pelaksanaan.destroy', $pel->id) }}">
                        @csrf
                        @method('DELETE')
                        <input required type="hidden" name="id" value="{{ $pel->id }}">
                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1">Delete</button>
                      </form>
                    </td>
                  @endif
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
      </div>
    </div>
  </div>

  <!-- Modal form data pelaksanaan -->
  <div class="modal fade" id="formdatapelaksanaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="{{ route('pelaksanaan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Pelaksanaan Kegiatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="name">Bulan - Tahun</div>
              <div class="value">
                <input pattern="\d{1,2}-\d{4}" class="form-control bg-white border-1 small mr-4" id="input-month" type="text" name="bulan_tahun">
              </div>
            </div>

            <div class="form-row">
              <div class="name">Jenis Kegiatan</div>
              <div class="value">
                <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jenis_kegiatan" required>
                  <option value="">-Pilih-</option>
                  @foreach ($jeniskegiatan as $jenis)
                    <option value="{{ $jenis->namakegiatan }}"> {{ $jenis->namakegiatan }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="name">No. Sprint</div>
              <div class="value">
                <input class="form-control bg-white border-1 small mr-4" type="number" name="no_sprint">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Tentang</div>
              <div id="wrapper-file-pelaksanaan" class="value">
                <div class="input-group js-input-file">
                  <input type="file" id="file-pelaksanaan" class="form-control" name="file_pelaksanaan[]" multiple="true">
                  <button type="button" id="btn-add-file-pelaksanaan" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="name"></div>
              <div class="value">
                <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                  file size 50 MB
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Waktu</div>
              <div class="value">
                <input class="form-control bg-white border-1 small mr-4" type="time" name="waktu">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Personal</div>
              <div class="value">
                @foreach ($users as $user)
                  <input value="{{ $user->nama_pengguna }}" class="form-control bg-white border-1 small mr-4" type="text" name="personal" readonly>
                @endforeach
                {{-- <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="personal" required>
                  <option value="">-Pilih-</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->nama_pengguna }}"> {{ $user->nama_pengguna }}</option>
                  @endforeach
                </select> --}}
              </div>
            </div>
            <div class="form-row">
              <div class="name">Laporan Kegiatan</div>
              <div id="wrapper-file-laporan" class="value">
                <div class="input-group js-input-file">
                  <input type="file" id="file-laporan" class="form-control" name="file_laporan[]" multiple="true">
                  <button type="button" id="btn-add-file-laporan" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="name"></div>
              <div class="value">
                <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                  file size 50 MB
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Perwaktu</div>
              <div id="wrapper-file-perwaktu" class="value">
                <div class="input-group js-input-file">
                  <input type="file" id="file-perwaktu" class="form-control" name="file_perwaktu[]" multiple="true">
                  <button type="button" id="btn-add-file-perwaktu" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="name"></div>
              <div class="value">
                <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                  file size 50 MB
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Outcome</div>
              <div class="value">
                <input id="outcome" type="hidden" name="outcome">
                <trix-editor input="outcome"></trix-editor>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-secondary" href="{{ route('pelaksanaan.index') }}">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal -->
@endsection

@push('js')
  <script>
    var valid = false;

    function validate_fileupload(input_element) {
      var el = document.getElementById("wrapper-file-pelaksanaan", "wrapper-file-laporan", "wrapper-file-perwaktu");
      var fileName = input_element.value;
      var allowed_extensions = new Array("jpg", "png", "gif", "pdf");
      var file_extension = fileName.split('.').pop();
      for (var i = 0; i < allowed_extensions.length; i++) {
        if (allowed_extensions[i] == file_extension) {
          valid = true; // valid file extension
          return;
        }
      }
      el.innerHTML = "Invalid file";
      valid = false;
    }

    function valid_form() {
      return valid;
    }
  </script>
  <script>
    var valid = false;

    function validate_fileupload(input_element) {
      var el = document.getElementById("wrapper-file-pelaksanaan");
      var fileName = input_element.value;
      var allowed_extensions = new Array("jpg", "png", "gif", "pdf");
      var file_extension = fileName.split('.').pop();
      for (var i = 0; i < allowed_extensions.length; i++) {
        if (allowed_extensions[i] == file_extension) {
          valid = true; // valid file extension
          return;
        }
      }
      el.innerHTML = "Invalid file";
      valid = false;
    }

    function valid_form() {
      return valid;
    }
  </script>
  <script>
    var valid = false;

    function validate_fileupload2(input_element) {
      var el = document.getElementById("wrapper-file-laporan");
      var fileName = input_element.value;
      var allowed_extensions = new Array("jpg", "png", "gif", "pdf");
      var file_extension = fileName.split('.').pop();
      for (var i = 0; i < allowed_extensions.length; i++) {
        if (allowed_extensions[i] == file_extension) {
          valid = true; // valid file extension
          return;
        }
      }
      el.innerHTML = "Invalid file";
      valid = false;
    }

    function valid_form() {
      return valid;
    }
  </script>
  <script>
    var valid = false;

    function validate_fileupload3(input_element) {
      var el = document.getElementById("wrapper-file-perwaktu");
      var fileName = input_element.value;
      var allowed_extensions = new Array("jpg", "png", "gif", "pdf");
      var file_extension = fileName.split('.').pop();
      for (var i = 0; i < allowed_extensions.length; i++) {
        if (allowed_extensions[i] == file_extension) {
          valid = true; // valid file extension
          return;
        }
      }
      el.innerHTML = "Invalid file";
      valid = false;
    }

    function valid_form() {
      return valid;
    }
  </script>
  <script>
    $(document).ready(function() {
      $("#input-month").datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
      });

      $("#btn-add-file-pelaksanaan").click(function() {
        var wrapper = $("<div class=\"input-group js-input-file mt-2\"></div>");
        var input = $("<input required type=\"file\" class=\"form-control\" name=\"file_pelaksanaan[]\" multiple=\"true\">");
        var button = $(
          "<button type=\"button\" style=\"border-top-left-radius: 0; border-bottom-left-radius: 0; background-color: red\" class=\"btn\"></button>");
        var icon = $("<i class=\"fas fa-trash\"></i>")

        button.append(icon);
        wrapper.append(input);
        wrapper.append(button);

        button.click(function() {
          $(this).parent().remove();
        });

        $("#wrapper-file-pelaksanaan").append(wrapper);
      });
    });
    $(document).ready(function() {
      $("#btn-add-file-laporan").click(function() {
        var wrapper = $("<div class=\"input-group js-input-file mt-2\"></div>");
        var input = $("<input required type=\"file\" class=\"form-control\" name=\"file_laporan[]\" multiple=\"true\">");
        var button = $(
          "<button type=\"button\" style=\"border-top-left-radius: 0; border-bottom-left-radius: 0; background-color: red\" class=\"btn\"></button>");
        var icon = $("<i class=\"fas fa-trash\"></i>")

        button.append(icon);
        wrapper.append(input);
        wrapper.append(button);

        button.click(function() {
          $(this).parent().remove();
        });

        $("#wrapper-file-laporan").append(wrapper);
      });
    });
    $(document).ready(function() {
      $("#btn-add-file-perwaktu").click(function() {
        var wrapper = $("<div class=\"input-group js-input-file mt-2\"></div>");
        var input = $("<input required type=\"file\" class=\"form-control\" name=\"file_perwaktu[]\" multiple=\"true\">");
        var button = $(
          "<button type=\"button\" style=\"border-top-left-radius: 0; border-bottom-left-radius: 0; background-color: red\" class=\"btn\"></button>");
        var icon = $("<i class=\"fas fa-trash\"></i>")

        button.append(icon);
        wrapper.append(input);
        wrapper.append(button);

        button.click(function() {
          $(this).parent().remove();
        });

        $("#wrapper-file-perwaktu").append(wrapper);
      });
    });
  </script>
@endpush
