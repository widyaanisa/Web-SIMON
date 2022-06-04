@extends('layouts.dashboardsurveiyor')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">Pelaksanaan Kegiatan</h1>
    </div>

    <div class="card shadow mb-4">
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
                                <th width="100px"> </th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <a href="#" class="btn btn-sm btn-outline-success mr-1 mb-1"><i
                                            class="fas fa-eye"></i>View</a>
                                </td>
                            </tr>
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
            </ul>
        </nav><br>
    </div>
</div>
</div>

@endsection