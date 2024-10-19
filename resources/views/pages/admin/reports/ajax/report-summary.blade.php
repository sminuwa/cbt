
<div class="row">
    <div class="col-xl-6 col-md-12 box-col-6">
        <div class="card border-none">
          <div class="card-header"> 
            <h4>Above 50%</h4>
          </div>
          <div class="card-body chart-block"> 
            <canvas id="aboveChart"> </canvas>
          </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 box-col-6">
        <div class="card border-none">
          <div class="card-header"> 
            <h4>Below 50%</h4>
          </div>
          <div class="card-body chart-block"> 
            <canvas id="belowChart"> </canvas>
          </div>
        </div>
    </div>
</div>
{{-- @json($statistics) --}}
<div class="table-responsive">
    <table class="display" id="export-button-sample">
        <thead>
        <tr>
            <th>#</th>
            <th>Exam No.</th>
            <th>Fullname</th>
            <th>P1</th>
            <th>P2</th>
            <th>P3</th>
            <th>PE</th>
            <th>PA</th>
        </tr>
        </thead>
        <tbody>
        @foreach($candidates as $candidate)
            <tr>
                <td>
                    <img class="img-fluid table-avtar" src="{{ $candidate->passport() }}" alt="">
                </td>
                <td>{{$candidate->indexing}}</td>
                <td>{{$candidate->fullname}}</td>
                <td>{{ $candidate->P1 ?? 0 }}</td>
                <td>{{ $candidate->P2 ?? 0 }}</td>
                <td>{{ $candidate->P3 ?? 0 }}</td>
                <td>{{ $candidate->PE ?? 0 }}</td>
                <td>{{ $candidate->PA ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
(function () {
  
  var barOptions = {
    scaleBeginAtZero: true,
    scaleShowGridLines: true,
    scaleGridLineColor: "rgba(0,0,0,0.1)",
    scaleGridLineWidth: 1,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines: true,
    barShowStroke: true,
    barStrokeWidth: 2,
    barValueSpacing: 5,
    barDatasetSpacing: 1,
  };
  var belowChartCtx = document.getElementById("belowChart").getContext("2d");
//   var aboveChartCtx = document.getElementById("aboveChart").getContext("2d");
  var belowChart = new Chart(belowChartCtx).Bar(
    {
        labels: ["P1", "P2", "P3", "PE", "PA"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(0, 102, 102, 0.2)",
                strokeColor: RihoAdminConfig.primary,
                highlightFill: "rgba(0, 102, 102, 0.2)",
                highlightStroke: RihoAdminConfig.primary,
                data: [
                        {{ $statistics->P1_above_50_count }}, 
                        {{ $statistics->P2_above_50_count }}, 
                        {{ $statistics->P3_above_50_count }}, 
                        {{ $statistics->PE_above_50_count }}, 
                        {{ $statistics->PA_above_50_count }}, 
                    ],
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(254, 106, 73, 0.3)", 
                strokeColor: RihoAdminConfig.secondary,
                highlightFill: "rgba(254, 106, 73, 0.3)",
                highlightStroke: RihoAdminConfig.secondary, 
                data: [
                        {{ $statistics->P1_below_50_count }}, 
                        {{ $statistics->P2_below_50_count }}, 
                        {{ $statistics->P3_below_50_count }}, 
                        {{ $statistics->PE_below_50_count }}, 
                        {{ $statistics->PA_below_50_count }}, 
                    ],
            },
        ],
            
    }, 
    barOptions
  );
//   var aboveChart = new Chart(aboveChartCtx).Bar(
//     {
//         labels: ["P1", "P2", "P3", "PE", "PA"],
//         datasets: [
//         {
//             label: "Below",
//             fillColor: "rgba(0, 102, 102, 0.5)",
//             strokeColor: RihoAdminConfig.primary,
//             highlightFill: "rgba(0, 102, 102, 0.2)",
//             highlightStroke: RihoAdminConfig.primary,
//             data: [
//                 {{ $statistics->P1_above_50_count }}, 
//                 {{ $statistics->P2_above_50_count }}, 
//                 {{ $statistics->P3_above_50_count }}, 
//                 {{ $statistics->PE_above_50_count }}, 
//                 {{ $statistics->PA_above_50_count }}, 
//             ],
//         },
//         ],
//     }, 
//     barOptions
//   );
  
  
  
})();

</script>