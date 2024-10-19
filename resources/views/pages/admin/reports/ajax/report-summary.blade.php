
<div class="row">
    <div class="col-xl-6 col-md-12 box-col-6">
        <div class="card border-none">
          <div class="card-header"> 
            <h4>Score Above & Below 50</h4>
          </div>
          <div class="card-body chart-block"> 
            <canvas id="barChart"> </canvas>
          </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 box-col-6">
        <div class="card border-none">
          <div class="card-header"> 
            <h4>Percentage Above & Below 50</h4>
          </div>
          <div class="card-body chart-block"> 
            <canvas id="pieChart"> </canvas>
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

var ctx = document.getElementById('barChart');

var barChart =new Chart(ctx, {
    type: 'bar',
    data: {
    labels: ["P1", "P2", "P3", "PE", "PA"],
    datasets: [
        {
            label: "Above 50",
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
            label: "Below 50",
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
        }],
    },
    
    options: { 
        plugins: {
            tooltip: {
                enabled: false  // Disable tooltips
            },
            datalabels: {  // Configure datalabels to show on top of each bar
                display: true,
                align: 'end',
                anchor: 'end',
                formatter: (value) => value, // Display the value itself
                color: 'black',  // Customize text color
                font: {
                    weight: 'bold'
                }
            },
            title: {
                display: true,
                text: 'Score Above & Below 50',
                color: '#006666',
                font: {
                    // weight: 'bold',
                    size: 12
                }
            },
            
        }
    },
    plugins: [ChartDataLabels]
  });
</script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> --}}
