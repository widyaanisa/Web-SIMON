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
      <h1 class="h3 mb-0 text-primary">Data User</h1>
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
          <a class="btn btn-info add-new " href="#" data-toggle="modal" data-target="#adduser"><i class="fa fa-plus"></i>
            Add New
          </a>
          {{-- <form method="POST" enctype="multipart/form-data" action="/mainadmin/users/import">
            @csrf
            <div class="input-group">
              <input required type="file" name="file" class="form-control bg-white border-1 small">
              <div class="input-group-append">
                <button class="btn btn-primary ml-1" type="submit">
                  <i class="fas fa-upload fa-sm"></i> Import Excel
                </button>
                <a class="btn btn-primary ml-1" href="/mainadmin/users/export">
                  <i class="fas fa-download fa-sm"></i> Export Excel
                </a>
              </div>
            </div>
          </form> --}}
        @endif
        <!-- Button trigger modal -->
        
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
          Import / Export
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="{{ $role == 'mainadmin' ? '/mainadmin/users/import' : ($role == 'mainadmin' ? '/admin/users/import' : '/admin/users/export') }}">
                  @csrf
                  <div class="input-group">
                    <input required type="file" name="file" class="form-control bg-white border-1 small">
                    <div class="input-group-append">
                      <button class="btn btn-primary ml-1" type="submit">
                        <i class="fas fa-upload fa-sm"></i> Import Excel
                      </button>
                      @if (auth()->user()->role == 'mainadmin' || auth()->user()->role == 'admin')
                      <a class="btn btn-primary ml-1" href="/mainadmin/users/export">
                        <i class="fas fa-download fa-sm"></i> Export Excel
                      </a>
                      @endif
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      @if (Auth::check())
        @if ($role == 'mainadmin')
          <form method="GET" action="{{ url('mainadmin/users') }}">
            <input type="text" class="form-control " name="keyword" style="width:100%" placeholder="Cari Data ...">
          </form>
        @endif
      @endif
      @if (Auth::check())
        @if ($role == 'admin')
          <form method="GET" action="{{ url('admin/users') }}">
            <input type="text" class="form-control " name="keyword" style="width:100%" placeholder="Cari Data ...">
          </form>
        @endif
      @endif

      <div class="card-body">
        <div class="table-responsive">
          <table id="datauser" class="table table-bordered text-center">
            <thead>
              <tr>
                <th width="55px">No.</th>
                <th width="130px">Role</th>
                <th width="130px">Username</th>
                <th width="150px">Nama</th>
                <th width="100px">Pangkat</th>
                <th width="97px">NRP</th>
                <th width="158px">Jabatan</th>
                <th width="145px">Tempat Lahir</th>
                <th width="165px">Tanggal Lahir</th>
                <th width="140px">Jenis Kelamin</th>
                <th width="90px">Agama</th>
                <th width="252px">Email</th>
                <th width="184px"> </th>
              </tr>
            </thead>
            @php
              $no = 0;
            @endphp
            @foreach ($datauser as $key => $du)
              <tbody>
                <tr>
                  <td>{{ ++$key + ($datauser->currentPage() - 1) * $datauser->perPage() }}</td>
                  <td>{{ $du->role }}</td>
                  <td>{{ $du->username }}</td>
                  <td>{{ $du->nama_pengguna }}</td>
                  <td>{{ $du->pangkat }}</td>
                  <td>{{ $du->NRP }}</td>
                  <td>{{ $du->jabatan }}</td>
                  <td>{{ $du->tempatlahir }}</td>
                  <td>{{ $du->tanggallahir }}</td>
                  <td>{{ $du->jeniskelamin }}</td>
                  <td>{{ $du->agama }}</td>
                  <td>{{ $du->email }}</td>
                  <td>
                    @if ($role == 'mainadmin')
                      <form action="{{ route('delete-user', $du->id_user) }}" method="POST">
                        <a href="#" class="btn btn-sm btn-outline-warning mr-1 mb-1 edit" data-toggle="modal" data-target="#updateuser{{ $du->id_user }}"><i
                            class="fas fa-edit"></i>Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1"><i class="fas fa-trash"></i>Delete</button>
                      </form>
                    @elseif ($role == 'admin' && $du->role != 'mainadmin')
                      <form action="{{ route('delete-user', $du->id_user) }}" method="POST">
                        <a href="#" class="btn btn-sm btn-outline-warning mr-1 mb-1 edit" data-toggle="modal" data-target="#updateuser{{ $du->id_user }}"><i
                            class="fas fa-edit"></i>Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger mr-1 mb-1"><i class="fas fa-trash"></i>Delete</button>
                      </form>
                    @endif
                  </td>
                </tr>
              </tbody>
            @endforeach
          </table>
          Halaman : {{ $datauser->currentPage() }} <br />
          Jumlah Data : {{ $datauser->total() }} <br />
          Data Per Halaman : {{ $datauser->perPage() }} <br />
        </div>
        <div class="d-flex justify-content-center">
          {!! $datauser->links() !!}
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Manage User -->
  <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('store-user') }} " class=" needs-validation">
            @csrf
            <div class="form-row">
              <div class="name">Username</div>
              <div class="value">
                <input pattern="[A-Za-z0-9]+" class="form-control bg-white border-1 small mr-4" type="text" name="username">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Passsword</div>
              <div class="value">
                <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                  class="form-control bg-white border-1 small mr-4" type="text" name="password" />
              </div>
            </div>
            <div class="form-row">
              <div class="name">Nama Pengguna</div>
              <div class="value">
                <input pattern="[a-zA-Z'-'\s]*" class="form-control bg-white border-1 small mr-4" type="text" name="nama_pengguna">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Pangkat</div>
              <div class="value">
                <input pattern="[a-zA-Z'-'\s]*" class="form-control bg-white border-1 small mr-4" type="text" name="pangkat">
              </div>
            </div>
            <div class="form-row">
              <div class="name">NRP</div>
              <div class="value">
                <input pattern="[0-9]{1,15}" class="form-control bg-white border-1 small mr-4" type="text" name="NRP">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Jabatan</div>
              <div class="value">
                <input pattern="[a-zA-Z'-'\s]*" class="form-control bg-white border-1 small mr-4" type="text" name="jabatan">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Tempat Lahir</div>
              <div class="value">
                <input pattern="[A-Za-z]{1,32}" class="form-control bg-white border-1 small mr-4" type="text" name="tempatlahir">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Tanggal Lahir</div>
              <div class="value">
                <input pattern="\d{1,2}/\d{1,2}/\d{4}" class="form-control bg-white border-1 small mr-4" type="date" name="tanggallahir">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Jenis Kelamin</div>
              <div class="value">
                <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jeniskelamin">
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="pria">Pria</option>
                  <option value="wanita">Wanita</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Agama</div>
              <div class="value">
                <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="agama">
                  <option value="">-- Pilih Agama --</option>
                  <option value="islam">Islam</option>
                  <option value="kristen">Kristen</option>
                  <option value="buddha">Buddha</option>
                  <option value="hindu">Hindu</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Email</div>
              <div class="value">
                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control bg-white border-1 small mr-4" type="text" name="email">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Role</div>
              <div class="value">
                <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="role">
                  <option value="">-- Pilih Role --</option>
                  @if (auth()->user()->role == 'mainadmin')
                    <option value="mainadmin">Main Admin</option>
                  @endif
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                  <option value="surveiyor">Surveiyor</option>
                </select>
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

  @foreach ($datauser as $du)
    <div class="modal fade" id="updateuser{{ $du->id_user }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action={{ route('update-user', $du->id_user) }} id="editForm">
              @method('PATCH')
              @csrf

              <div class="form-row">
                <div class="name">Username</div>
                <div class="value">
                  <input pattern="[A-Za-z0-9]+" class="form-control bg-white border-1 small mr-4" type="text" name="username" id="username"
                    value="{{ $du->username }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Password</div>
                <div class="value">
                  <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control bg-white border-1 small mr-4" type="text" name="password"
                    id="password" value="{{ $du->password }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Nama Pengguna</div>
                <div class="value">
                  <input pattern="[a-zA-Z'-'\s]*" class="form-control bg-white border-1 small mr-4" type="text" name="nama_pengguna" id="nama_pengguna"
                    value="{{ $du->nama_pengguna }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Pangkat</div>
                <div class="value">
                  <input pattern="[a-zA-Z'-'\s]*" class="form-control bg-white border-1 small mr-4" type="text" name="pangkat" id="pangkat"
                    value="{{ $du->pangkat }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">NRP</div>
                <div class="value">
                  <input pattern="[0-9]{1,15}" class="form-control bg-white border-1 small mr-4" type="text" name="NRP" id="NRP" value="{{ $du->NRP }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Jabatan</div>
                <div class="value">
                  <input pattern="[a-zA-Z'-'\s]*" class="form-control bg-white border-1 small mr-4" type="text" name="jabatan" id="jabatan"
                    value="{{ $du->jabatan }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Tempat Lahir</div>
                <div class="value">
                  <input pattern="[A-Za-z]{1,32}" class="form-control bg-white border-1 small mr-4" type="text" name="tempatlahir" id="tempatlahir"
                    value="{{ $du->tempatlahir }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Tanggal Lahir</div>
                <div class="value">
                  <input pattern="\d{1,2}/\d{1,2}/\d{4}" class="form-control bg-white border-1 small mr-4" type="date" name="tanggallahir" id="tanggallahir"
                    value="{{ $du->tanggallahir }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Jenis Kelamin</div>
                <div class="value">
                  <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jeniskelamin">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option {{ $du->jeniskelamin == 'pria' ? 'selected' : '' }} value="pria">Pria</option>
                    <option {{ $du->jeniskelamin == 'wanita' ? 'selected' : '' }} value="wanita">Wanita</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="name">Agama</div>
                <div class="value">
                  <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="agama">
                    <option value="">-- Pilih Agama --</option>
                    <option {{ $du->agama == 'islam' ? 'selected' : '' }} value="islam">Islam</option>
                    <option {{ $du->agama == 'kristen' ? 'selected' : '' }} value="kristen">Kristen</option>
                    <option {{ $du->agama == 'buddha' ? 'selected' : '' }} value="buddha">Buddha</option>
                    <option {{ $du->agama == 'hindu' ? 'selected' : '' }} value="hindu">Hindu</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="name">Email</div>
                <div class="value">
                  <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control bg-white border-1 small mr-4" type="text" name="email" id="email"
                    value="{{ $du->email }}">
                </div>
              </div>
              <div class="form-row">
                <div class="name">Role</div>
                <div class="value">
                  <select required class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="role">
                    <option value="">-- Pilih Role --</option>
                    <option {{ $du->role == 'mainadmin' ? 'selected' : '' }} value="mainadmin">Main Admin</option>
                    <option {{ $du->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                    <option {{ $du->role == 'user' ? 'selected' : '' }} value="user">User</option>
                    <option {{ $du->role == 'surveiyor' ? 'selected' : '' }} value="surveiyor">Surveiyor</option>
                  </select>
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
    <style>
      .select::after.error {
        color: red;
      }

    </style>
  @endforeach
  <!--End Modal-->
@endsection
