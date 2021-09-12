@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    @if(Request::get('id'))
        <a class="btn btn-danger" href="{{ URL::previous() }}">
            <i class="fa fa-arrow-left"></i>
            Regresar
        </a>
    @endif


    <div class="row match-height justify-content-center">

            <!-- Line Chart Starts -->
    <div class="col-6">
        <div class="card">
          <div
            class="
              card-header
              d-flex
              flex-sm-row flex-column
              justify-content-md-between
              align-items-start
              justify-content-start
            "
          >
            <div>
              <h4 class="card-title mb-25">Medición STCV</h4>
            </div>
          </div>
          <div class="card-body">
            <div id="line-chart"></div>
          </div>
        </div>
      </div>
      <!-- Line Chart Ends -->
    </div>

</section>
@endsection

@section('vendor-script')
<!-- vendor files -->
@endsection

@section('page-script')
<script>
  let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    document.addEventListener('DOMContentLoaded', function () {
        //------------PETICIÓN ASINCRONA  ------------
                    //-----------------------------------------------

                    fetch(`{{route("get.contracts.admin")}}`, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'post',
                    })
                    .then(response => response.text())
                    .then(resultText => (
                        data = JSON.parse(resultText),
                        console.log(data)
                                                
                    ))
                    .catch(function (error) {
                        console.log(error);
                    });
                    

          // Line Chart
  // --------------------------------------------------------------------
  var lineChartEl = document.querySelector('#line-chart'),
    lineChartConfig = {
      chart: {
        height: 400,
        type: 'line',
        zoom: {
          enabled: false
        },
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      series: [
        {
          data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100, 150, 100, 50]
        }
      ],
      markers: {
        strokeWidth: 7,
        strokeOpacity: 1,
        strokeColors: [window.colors.solid.white],
        colors: [window.colors.solid.warning]
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      colors: [window.colors.solid.warning],
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        },
        padding: {
          top: -20
        }
      },
      tooltip: {
        custom: function (data) {
          return (
            '<div class="px-1 py-50">' +
            '<span>' +
            data.series[data.seriesIndex][data.dataPointIndex] +
            '%</span>' +
            '</div>'
          );
        }
      },
      xaxis: {
        categories: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12',
          '20/12',
          '21/12'
        ]
      },
    };
  if (typeof lineChartEl !== undefined && lineChartEl !== null) {
    var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();
  }

    })

    
</script>
@endsection
