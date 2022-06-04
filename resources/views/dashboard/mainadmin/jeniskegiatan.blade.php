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
      <h1 class="h3 mb-0 text-primary">Jenis Kegiatan</h1>
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
        @if (auth()->user()->role == 'mainadmin' || auth()->user()->role == 'admin')
          <a class="btn btn-info add-new " href="#" data-toggle="modal" data-target="#addjk"><i class="fa fa-plus"></i> Add New</a>
        @endif
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="32px">No.</th>
                <th width="140px">Nama</th>
                <th width="53px">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($jeniskegiatan as $jk)
                <tr>
                  <td scope="row">{{ $loop->iteration + ($jeniskegiatan->currentPage() - 1) * $jeniskegiatan->perPage() }}</td>
                  <td>{{ $jk->namakegiatan }}</td>
                  <td>
                    @if (auth()->user()->role == 'mainadmin' || auth()->user()->role == 'admin')
                      <a data-toggle="modal" data-target="#editjk-{{ $jk->id_jeniskegiatan }}" href="#"
                        class="btn btn-edit-jk btn-sm btn-outline-primary mr-1 mb-1"><i class="fas fa-edit"></i>Edit
                      </a>

                      <form method="POST" style="display: inline" action="{{ route('jeniskegiatan.destroy', $jk->id_jeniskegiatan) }}">
                        @csrf
                        @method('DELETE')
                        <input required type="hidden" name="id" value="{{ $jk->id_jeniskegiatan }}">
                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1">Delete</button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          Halaman : {{ $jeniskegiatan->currentPage() }} <br />
          Jumlah Data : {{ $jeniskegiatan->total() }} <br />
          Data Per Halaman : {{ $jeniskegiatan->perPage() }} <br />
        </div>
        <div class="d-flex justify-content-center">
          {!! $jeniskegiatan->links() !!}
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Form Jenis Kegiatan -->
  <div class="modal fade" id="addjk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form action="{{ route('jeniskegiatan.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-row">
              <div class="name">Nama</div>
              <div class="value">
                <input pattern="[A-Za-z]{1,32}" class="form-control bg-white border-1 small mr-4" type="text" name="namakegiatan">
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

  @foreach ($jeniskegiatan as $jk)
    <div class="modal fade" id="editjk-{{ $jk->id_jeniskegiatan }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Kegiatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ route('jeniskegiatan.update', $jk->id_jeniskegiatan) }}" method="POST">
              @method('PATCH')
              {{ csrf_field() }}
              <div class="form-row">
                <div class="name">Nama</div>
                <div class="value">
                  <input required value="{{ $jk->namakegiatan }}" id="edit-jk-nama-{{ $jk->id_jeniskegiatan }}"
                    class="form-control bg-white border-1 small mr-4" type="text" name="namakegiatan">
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
  @endforeach
@endsection
