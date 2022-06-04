@extends('layouts.dashboardadmin')

@section('content')
  <div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-primary">Dashboard</h1>
    </div>
    <div class="row">
      <!-- Jumlah Data Pelaksanaan -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pelaksanaan Bulan Ini
                </div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $pelaksanaanBulanIni }}</div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Rencana Kegiatan</h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="grafikrencanakegiatan"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Notifikasi</h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <div class="chart-pie pb-2">
                @foreach ($terlaksana as $item_terlaksana)
                @if ($item_terlaksana->status_id == '1') 
                  <div class="alert-box alertterlaksana"><span>{{ $item_terlaksana->bulan_tahun }} - {{ $item_terlaksana->jenis_kegiatan }}</div>
                  @elseif ($item_terlaksana->status_id == '2') 
                  <div class="alert-box alertbelumterlaksana"><span>{{ $item_terlaksana->bulan_tahun }} - {{ $item_terlaksana->jenis_kegiatan }}</div>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-2">
                <i class="fas fa-circle text-warning"></i> Belum terlaksana
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-success"></i> Sudah terlaksana
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pelaksanaan</h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="grafikpelaksanaan"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pelaksanaan</h6>
          </div>

          <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
              <canvas id="peaksanaanPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> Januari
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-success"></i> Februari
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-info"></i> Maret
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-warning"></i> April
              </span></br>
              <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> Mei
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-success"></i> Juni
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-info"></i> Juli
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-warning"></i> Agustus
              </span></br>
              <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> September
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-success"></i> Oktober
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-info"></i> November
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-warning"></i> Desember
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Master</h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="grafikdatamaster"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
  @push('js')
    <script>
      var rencanaKegiatan = document.getElementById("grafikrencanakegiatan");
      var rencanaLineChart = new Chart(rencanaKegiatan, {
        type: 'line',
        data: {
          labels: @json($daftarTahun),
          datasets: [{
            label: "Jumlah Rencana",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: @json($rencanaPerTahun),
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });

      var pelaksanaan = document.getElementById("grafikpelaksanaan");
      var pelaksanaanLineChart = new Chart(pelaksanaan, {
        type: 'line',
        data: {
          labels: @json($daftarTahun),
          datasets: [{
            label: "Jumlah Terlaksana",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: @json($pelaksanaanPerTahun),
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });

      var master = document.getElementById("grafikdatamaster");
      var masterLineChart = new Chart(master, {
        type: 'line',
        data: {
          labels: @json($daftarTahun),
          datasets: [{
            label: "Jumlah Rencana",
            lineTension: 0.3,
            backgroundColor: "rgba(255, 215, 0, 0.05)",
            borderColor: "rgba(255, 215, 0, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(255, 215, 0, 1)",
            pointBorderColor: "rgba(255, 215, 0, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(255, 215, 0, 1)",
            pointHoverBorderColor: "rgba(255, 215, 0, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: @json($rencanaPerTahun),
          }, {
            label: "Jumlah Terlaksana",
            lineTension: 0.3,
            backgroundColor: "rgba(0, 255, 127, 0.05)",
            borderColor: "rgba(0, 255, 127, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(0, 255, 127, 1)",
            pointBorderColor: "rgba(0, 255, 127, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(0, 255, 127, 1)",
            pointHoverBorderColor: "rgba(0, 255, 127, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: @json($pelaksanaanPerTahun),
          }, {
            label: "Jumlah Belum Terlaksana",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: @json($masterPerTahun),
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });

      var pelaksanaanPerBulan = document.getElementById("peaksanaanPieChart");
      var peaksanaanPieChart = new Chart(pelaksanaanPerBulan, {
        type: 'doughnut',
        data: {
          labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
          datasets: [{
            data: @json($pelaksanaanPerBulan),
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#ffe135', '#4e73df', '#1cc88a', '#36b9cc', '#ffe135', '#4e73df', '#1cc88a', '#36b9cc',
              '#ffe135'
            ],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#ffc107', '#2e59d9', '#17a673', '#2c9faf', '#ffc107', '#2e59d9', '#17a673', '#2c9faf',
              '#ffc107'
            ],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: false
          },
          cutoutPercentage: 80,
        },
      });
    </script>
  @endpush
