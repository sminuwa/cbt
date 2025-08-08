
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
            
            <canvas id="pieChart" height="210"> </canvas>
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
            <th>Indexing (Exam No.)</th>
            <th>Fullname</th>
            <th>Year</th>
            @foreach($subjects as $subject)
                <th>{{ $subject->subject_code }}</th>
            @endforeach
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
                <td>{{ $candidate->year ?? date('Y') }}</td>
                @foreach($subjects as $subject)
                    @php
                        $columnAlias = 'subject_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $subject->subject_code);
                    @endphp
                    <td>{{ $candidate->{$columnAlias} ?? 0 }}</td>
                @endforeach
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
    labels: [@foreach($subjects as $subject)"{{ $subject->subject_code }}",@endforeach],
    datasets: [
        {
            label: "Above 50",
            fillColor: "rgba(0, 102, 102, 0.2)",
            strokeColor: RihoAdminConfig.primary,
            highlightFill: "rgba(0, 102, 102, 0.2)",
            highlightStroke: RihoAdminConfig.primary,
            data: [
                    @foreach($subjects as $subject)
                        {{ $statistics->{$subject->subject_code . '_above_50_count'} ?? 0 }}, 
                    @endforeach
                ],
        },
        {
            label: "Below 50",
            fillColor: "rgba(254, 106, 73, 0.3)", 
            strokeColor: RihoAdminConfig.secondary,
            highlightFill: "rgba(254, 106, 73, 0.3)",
            highlightStroke: RihoAdminConfig.secondary, 
            data: [
                    @foreach($subjects as $subject)
                        {{ $statistics->{$subject->subject_code . '_below_50_count'} ?? 0 }}, 
                    @endforeach
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
                // font: {
                //     weight: 'bold'
                // }
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


var ctx = document.getElementById('pieChart');
var barChart =new Chart(ctx, {
    type: 'pie',
    data: {
    labels: ["Above 50% (All Subjects)", "Below 50% (All Subjects)"],
    datasets: [{
        label: "Pie Chart",
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)'
        ],
        data: [
                {{ round(($percentages->above_50 / max(($percentages->above_50+$percentages->below_50),1)) * 100) }}, 
                {{ round(($percentages->below_50 / max(($percentages->above_50+$percentages->below_50),1)) * 100) }}, 
            ],
        hoverOffset: 4
    }],



    },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                enabled: false  // Disable tooltips
            },
            datalabels: {  // Configure datalabels to show on top of each bar
                color: 'white',  // Text color
                anchor: 'center',  // Position inside the pie
                align: 'center',   // Align to the center
                formatter: (value, ctx) => {
                    let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);  // Sum of all values
                    let percentage = (value / sum * 100).toFixed(2) + "%";  // Display percentage
                    return percentage;  // Return percentage
                }
                
            },
            // title: {
            //     display: true,
            //     text: 'Score Above & Below 50',
            //     color: '#006666',
            //     font: {
            //         // weight: 'bold',
            //         size: 12
            //     }
            // },
            
        }
    },
    plugins: [ChartDataLabels]
    
  });
</script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> --}}
