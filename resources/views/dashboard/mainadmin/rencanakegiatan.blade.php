@extends('layouts.dashboardmainadmin')

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
        Data tidak valid, mohon melengkapi form dengan benar.
      </div>
    @endif

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <a class="btn btn-info add-new " href="#" data-toggle="modal" data-target="#addrk"><i class="fa fa-plus"></i> Add New</a>
      </div>
      <div class="card-body">
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
                      <input required type="hidden" name="id" value="{{ $rk->id_rencana }}">
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
          {!! $rencanakegiatan->links() !!}
        </div>
      </div>

    </div>
  </div>

  <!-- Modal Form Rencana Kegiatan -->
  <div class="modal fade" id="addrk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Data Rencana Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form action="rencanakegiatanmainadmin/create" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-row">
              <div class="name">Bulan - Tahun</div>
              <div class="value">
                <input  pattern="\d{1,2}-\d{4}" class="form-control bg-white border-1 small mr-4 input-month" type="text" name="bulan_tahun">
              </div>
            </div>

            <div class="form-row">
              <div class="name">Jenis Kegiatan</div>
              <div class="value">
                <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jeniskegiatan">
                  <option value="">-Pilih-</option>
                  @foreach ($jeniskegiatan as $jenis)
                    <option value="{{ $jenis->namakegiatan }}"> {{ $jenis->namakegiatan }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="name">Tentang</div>
              <div id="wrapper-tentang" class="value">
                <div class="input-group js-input-file">
                  <input required type="file" id="tentang" class="form-control" name="tentang[]" multiple="true">
                  <button type="button" id="btn-add-file" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" class="btn btn-primary">
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
              <div class="name">Personal</div>
              <div class="value">
                  @foreach ($users as $user)
                  <input value="{{ $user->nama_pengguna }}"class="form-control bg-white border-1 small mr-4" type="text" name="personal" readonly>
                  @endforeach
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- End Modal -->

  {{-- Modal Edit Start --}}
  <div class="modal fade" id="editrk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Rencana Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form action="rencanakegiatanmainadmin/update" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input required type="hidden" name="id" id="edit-rk-id">
            <div class="form-row">
              <div class="name">Bulan - Tahun</div>
              <div class="value">
                <input required id="edit-rk-bulan" class="form-control bg-white border-1 small mr-4 input-month" type="text" name="bulan_tahun">
              </div>
            </div>

            <div class="form-row">
              <div class="name">Jenis Kegiatan</div>
              <div class="value">
                <select id="edit-rk-jenis" class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jeniskegiatan">
                  <option value="">-Pilih-</option>
                  @foreach ($jeniskegiatan as $jenis)
                    <option value="{{ $jenis->namakegiatan }}"> {{ $jenis->namakegiatan }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="name">Tentang</div>
              <div class="value">
                <div class="input-group js-input-file">
                  <input required id="edit-rk-tentang" type="file" id="tentang" class="form-control-file" name="tentang[]" multiple="true">
                </div>
                <div class="label--desc">Upload your PDF, JPG, JPEG, PNG or any other relevant file. Max
                  file size 50 MB</div>
              </div>
            </div>

            <div class="form-row">
              <div class="name">Personal</div>
              <div class="value">
                <select id="edit-rk-personal" class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="personal">
                  <option value="">-Pilih-</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->nama_pengguna }}"> {{ $user->nama_pengguna }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  {{-- Modal Edit End --}}
@endsection
@push('js')
  <script>
    $(document).ready(function() {
      $(".input-month").datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
      });
      $("#btn-add-file").click(function() {
        var wrapper = $("<div class=\"input-group js-input-file mt-2\"></div>");
        var input = $("<input required type=\"file\" class=\"form-control\" name=\"tentang[]\" multiple=\"true\">");
        var button = $(
          "<button type=\"button\" style=\"border-top-left-radius: 0; border-bottom-left-radius: 0; background-color: red\" class=\"btn\"></button>");
        var icon = $("<i class=\"fas fa-trash\"></i>")

        button.append(icon);
        wrapper.append(input);
        wrapper.append(button);

        button.click(function() {
          $(this).parent().remove();
        });

        $("#wrapper-tentang").append(wrapper);
      });
    });

    $(document).on("click", ".btn-edit-rk", function() {
      var id = $(this).data('id');
      var bulan = $(this).data('bulan');
      var jenis = $(this).data('jenis');
      var tentang = $(this).data('tentang');
      var personal = $(this).data('personal');
      console.log(bulan);
      $(".modal-body #edit-rk-id").val(id);
      $(".modal-body #edit-rk-bulan").val(bulan);
      $(".modal-body #edit-rk-jenis").val(jenis);
      $(".modal-body #edit-rk-tentang").val(tentang);
      $(".modal-body #edit-rk-personal").val(personal);
      // As pointed out in comments, 
      // it is unnecessary to have to manually call the modal.
      // $('#addBookDialog').modal('show');
    });
  </script>
@endpush
