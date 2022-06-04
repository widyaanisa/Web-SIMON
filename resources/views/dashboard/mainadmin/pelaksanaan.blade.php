@extends('layouts.dashboardmainadmin')

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Pelaksanaan Kegiatan</h1>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <a class="btn btn-info add-new " href="#" data-toggle="modal" data-target="#formdatapelaksanaanModal"><i class="fa fa-plus"></i> Add New</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="table-wrapper">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="55px">No.</th>
                  <th width="140px">Bulan - Tahun</th>
                  <th width="140px">Jenis kegiatan</th>
                  <th width="100px">No. Sprin</th>
                  <th width="140px">Tentang</th>
                  <th width="110px">Waktu</th>
                  <th width="150px">Personal</th>
                  <th width="160px">Laporan Kegiatan</th>
                  <th width="160px">Perwaktu</th>
                  <th width="180px">Outcome</th>
                  <th width="260px"> </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($daftarPelaksanaan as $pelaksanaan)
                  <tr>
                    <td>01</td>
                    <td>Januari 2022</td>
                    <td>Lidik</td>
                    <td>1</td>
                    <td>-</td>
                    <td>2022/01/18</td>
                    <td>Rizali</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                      <a href="#" class="btn btn-sm btn-outline-success mr-1 mb-1"><i class="fas fa-eye"></i>View</a>
                      <a href="#" class="btn btn-sm btn-outline-danger mr-1 mb-1"><i class="fas fa-trash"></i>Delete</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <nav>
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <span class="page-link">Sebelumnya</span>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item active"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">4</a></li>
          <li class="page-item"><a class="page-link" href="#">5</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Selanjutnya</a>
          </li>
        </ul></br>
      </nav>
    </div>
  </div>
  </div>

  <!-- Modal form data pelaksanaan -->
  <div class="modal fade" id="formdatapelaksanaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Data Pelaksanaan Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST">
            <div class="form-row">
              <div class="name">Bulan - Tahun</div>
              <div class="value">
                <input class="form-control bg-white border-1 small mr-4" type="text" name="bulantahun">
              </div>
            </div>

            <div class="form-row">
              <div class="name">Jenis Kegiatan</div>
              <div class="value">
                <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="jeniskegiatan">
                  <option value="datarencanakegiatan">Data Rencana Kegiatan</option>
                  <option value="datapelaksanaan">Data Pelaksanaan</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="name">No. Sprin</div>
              <div class="value">
                <input pattern= "[0-90]" class="form-control bg-white border-1 small mr-4" type="text" name="nosprin">
              </div>
            </div>
            <div class="form-row">
              <div class="name">Tentang</div>
              <div class="value">
                <div class="input-group js-input-file">
                  <input type="file" id="files" name="files" multiple>
                </div>
                <div class="label--desc">Upload your PDF or any other relevant file. Max
                  file size 50 MB</div>
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
                <select class="form-control bg-white border-1 small mr-4" placeholder="Pilih Data" aria-label="select" name="personal">
                  <option value="datarencanakegiatan">Data Rencana Kegiatan</option>
                  <option value="datapelaksanaan">Data Pelaksanaan</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Laporan Kegiatan</div>
              <div class="value">
                <div class="input-group js-input-file">
                  <input type="file" id="files" name="files" multiple>
                </div>
                <div class="label--desc">Upload your PDF or any other relevant file. Max
                  file size 50 MB</div>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Perwaktu</div>
              <div class="value">
                <div class="input-group js-input-file">
                  <input type="file" id="files" name="files" multiple>
                </div>
                <div class="label--desc">Upload your PDF or any other relevant file. Max
                  file size 50 MB</div>
              </div>
            </div>
            <div class="form-row">
              <div class="name">Outcome</div>
              <div class="value">
                <trix-editor input="outcome"></trix-editor>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="/">submit</a>
        </div>
      </div>
    </div>
  </div>

  <!-- End Modal -->
@endsection
