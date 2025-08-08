@extends('layouts.app')

@section('content')
<div class="row">
    @if(auth()->user()->id==1)
    <!-- First Row: Test Programme Performance (Full Width) -->
    <div class="col-sm-12 col-xl-12 box-col-12">
      <div class="card">
        <div class="card-header">
          <h4>Test Programme Performance</h4>
          <span class="f-12 f-light">Candidates and responses by programme</span>
        </div>
        <div class="card-body chart-block">
          <div class="chart-overflow" id="column-chart1"></div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <!-- Second Row: Exam Status and Top Scorers (Two columns) -->
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
            <div class="card-header">
            <h4>Exam Status Overview</h4>
            <span class="f-12 f-light">Distribution of exam completion status</span>
            </div>
            <div class="card-body chart-block">
            <div class="chart-overflow" id="pie-chart1"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
            <div class="card-header">
            <h4>Top Scorers by Programme</h4>
            <span class="f-12 f-light">Highest performing candidates per cadre</span>
            </div>
            <div class="card-body chart-block">
            <div class="chart-overflow" id="bar-chart1"></div>
            </div>
        </div>
    </div>

    @endif
    
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Dashboard</h4>
        </div>
        <div class="card-body">
          <div class="row">
            
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <div class="row">
                  <div class="col-xl-12 col-sm-12">
                    <div class="card o-hidden small-widget">
                        <div class="card-body total-project border-l-primary border-3">
                        <span class="f-light f-w-500 f-14">Total</span>
                        <div class="project-details"> 
                            <div class="project-counter"> 
                                <h2 class="f-w-600 d-inline">{{ $total_candidates }}</h2>
                                Candidates
                            </div>
                            <div class="product-sub bg-primary-light">
                                <i class="las la-users la-2x"></i>
                            </div>
                        </div>
                        @include('components.bubbles')
                        </div>
                    </div>
                </div>
                    <div class="col-xl-6 col-sm-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">Submitted</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{  $total_submitted }}</h2>
                                    Candidates
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-users la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">In progress</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{ $total_in_progress }}</h2>
                                    Candidates
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-users la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">Active Tests</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{ $active_tests }}</h2>
                                    / {{ $total_tests }} Total
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-clipboard-list la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">Recent Activity</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{ $recent_submissions }}</h2>
                                    This Week
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-chart-line la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
            
          </div>
        </div>
        <div class="card-footer">
          
        </div>
      </div>
    </div>
  </div>
@endsection


@section('script')
<script>
(function ($) {
  google.charts.load("current", { packages: ["corechart", "bar"] });
  google.charts.load("current", { packages: ["line"] });
  google.charts.load("current", { packages: ["corechart"] });
  google.charts.setOnLoadCallback(drawBasic);
  function drawBasic() {
    
    if ($("#column-chart1").length > 0) {
      // Dynamic subject data from database
      var chartData = [
        ['Test Programme', 'Candidates', 'Responses']
        @foreach($test_codes_performance as $performance)
          ,['{{ $performance->name }}', {{ $performance->candidate_count }}, {{ $performance->total_responses }}]
        @endforeach
      ];
      
      var a = google.visualization.arrayToDataTable(chartData),
        b = {
          chart: {
            title: "Test Performance by Programme",
            subtitle: "Candidates registered and responses submitted",
          },
          bars: "horizontal",
          hAxis: {
            format: "decimal",
            title: "Number of Candidates/Responses"
          },
          vAxis: {
            textStyle: {
              fontSize: 12
            }
          },
          height: 400,
          width: "100%",
          colors: [
            RihoAdminConfig.primary,
            RihoAdminConfig.secondary,
            "#51bb25",
            "#173878",
            "#f8d62b",
         ],
        },
        c = new google.charts.Bar(document.getElementById("column-chart1"));
      c.draw(a, google.charts.Bar.convertOptions(b));
    }
    
    if ($("#pie-chart1").length > 0) {
      // Dynamic exam status data
      var data = google.visualization.arrayToDataTable([
        ["Status", "Count"],
        ["Completed", {{ $exam_status['completed'] }}],
        ["In Progress", {{ $exam_status['in_progress'] }}],
        ["Not Started", {{ $exam_status['not_started'] }}]
      ]);
      
      var options = {
        title: "Exam Status Distribution",
        width: "100%",
        height: 300,
        colors: [
          "#28a745",  // Green for completed
          "#ffc107",  // Yellow for in progress
          "#dc3545"   // Red for not started
        ],
        legend: {
          position: 'bottom',
          alignment: 'center'
        },
        pieHole: 0.4,  // Creates a donut chart
      };
      
      var chart = new google.visualization.PieChart(
        document.getElementById("pie-chart1")
      );
      chart.draw(data, options);
    }
    
    if ($("#bar-chart1").length > 0) {
      @if(count($cadre_top_scorers) > 0)
      // Top scorers by cadre/programme chart
      var topScorersData = [
        ['Programme', 'Top Score (%)', { role: 'tooltip', type: 'string', p: { html: true } }]
        @foreach($cadre_top_scorers as $scorer)
          ,['{{ substr($scorer["cadre"], 0, 20) }}{{ strlen($scorer["cadre"]) > 20 ? "..." : "" }}', {{ $scorer['percentage'] }}, '<div style="padding:10px"><b>{{ $scorer["cadre"] }}</b><br/>Top Scorer: {{ $scorer["candidate_name"] }}<br/>Exam No: {{ $scorer["indexing"] }}<br/>Score: {{ $scorer["percentage"] }}% ({{ $scorer["average_score"] }}/{{ $scorer["total_questions"] }})</div>']
        @endforeach
      ];
      
      var topScorersChartData = google.visualization.arrayToDataTable(topScorersData);
      
      var topScorersOptions = {
        chart: {
          title: "Top Scorers by Programme",
          subtitle: "Highest performing candidate per cadre",
        },
        bars: 'horizontal',
        hAxis: {
          format: 'decimal',
          title: 'Score Percentage (%)',
          minValue: 0,
          maxValue: 100
        },
        height: 300,
        width: "100%",
        colors: ['#17a2b8'],
        tooltip: { isHtml: true },
        legend: { position: 'none' }
      };
      
      var topScorersChart = new google.charts.Bar(document.getElementById("bar-chart1"));
      topScorersChart.draw(topScorersChartData, google.charts.Bar.convertOptions(topScorersOptions));
      @else
      // No data available message
      document.getElementById("bar-chart1").innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:300px; color:#6c757d; flex-direction:column;"><i class="fa fa-chart-bar fa-3x mb-3"></i><p>No scoring data available yet</p><small>Data will appear once candidates complete exams</small></div>';
      @endif
    }
    
  }
  // Gantt chart
  google.charts.load("current", { packages: ["gantt"] });
  google.charts.setOnLoadCallback(drawChart);

  function daysToMilliseconds(days) {
    return days * 24 * 60 * 60 * 1000;
  }

  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn("string", "Task ID");
    data.addColumn("string", "Task Name");
    data.addColumn("string", "Resource");
    data.addColumn("date", "Start Date");
    data.addColumn("date", "End Date");
    data.addColumn("number", "Duration");
    data.addColumn("number", "Percent Complete");
    data.addColumn("string", "Dependencies");

    data.addRows([
      [
        "Research",
        "Find sources",
        null,
        new Date(2015, 0, 1),
        new Date(2015, 0, 5),
        null,
        100,
        null,
      ],
      [
        "Write",
        "Write paper",
        "write",
        null,
        new Date(2015, 0, 9),
        daysToMilliseconds(3),
        25,
        "Research,Outline",
      ],
      [
        "Cite",
        "Create bibliography",
        "write",
        null,
        new Date(2015, 0, 7),
        daysToMilliseconds(1),
        20,
        "Research",
      ],
      [
        "Complete",
        "Hand in paper",
        "complete",
        null,
        new Date(2015, 0, 10),
        daysToMilliseconds(1),
        0,
        "Cite,Write",
      ],
      [
        "Outline",
        "Outline paper",
        "write",
        null,
        new Date(2015, 0, 6),
        daysToMilliseconds(1),
        100,
        "Research",
      ],
    ]);

    var options = {
      height: 275,
      gantt: {
        criticalPathEnabled: false, // Critical path arrows will be the same as other arrows.
        arrow: {
          angle: 100,
          width: 5,
          color: "#51bb25",
          radius: 0,
        },

        palette: [
          {
            color: RihoAdminConfig.primary,
            dark: RihoAdminConfig.secondary,
            light: "#047afb",
          },
        ],
      },
    };
    var chart = new google.visualization.Gantt(
      document.getElementById("gantt_chart")
    );

    chart.draw(data, options);
  }
  // word tree
  google.charts.load("current1", { packages: ["wordtree"] });
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    var data = google.visualization.arrayToDataTable([
      ["Phrases"],
      ["cats are better than dogs"],
      ["cats eat kibble"],
      ["cats are better than hamsters"],
      ["cats are awesome"],
      ["cats are people too"],
      ["cats eat mice"],
      ["cats meowing"],
      ["cats in the cradle"],
      ["cats eat mice"],
      ["cats in the cradle lyrics"],
      ["cats eat kibble"],
      ["cats for adoption"],
      ["cats are family"],
      ["cats eat mice"],
      ["cats are better than kittens"],
      ["cats are evil"],
      ["cats are weird"],
      ["cats eat mice"],
    ]);

    var options = {
      wordtree: {
        format: "implicit",
        word: "cats",
      },
    };
    var chart = new google.visualization.WordTree(
      document.getElementById("wordtree_basic")
    );
    chart.draw(data, options);
  }
})(jQuery);
</script>

@endsection