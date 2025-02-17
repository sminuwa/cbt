@extends('layouts.app')

@section('content')
<div class="row">
    @if(auth()->user()->id==1)
    <div class="col-sm-12 col-xl-6 box-col-6">
      <div class="card">
        <div class="card-header">
          <h4>Paper Report</h4>
        </div>
        <div class="card-body chart-block">
          <div class="chart-overflow" id="column-chart1"></div>
        </div>
      </div>
  </div>
  <div class="col-sm-12 col-xl-6 box-col-6">
    <div class="card">
        <div class="card-header">
        <h4>Paper Report</h4>
        </div>
        <div class="card-body p-0 chart-block">
        <div class="chart-overflow" id="pie-chart1"></div>
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
                    {{-- <div class="col-xl-4 col-sm-6 ">
                        <div class="card o-hidden small-widget">
                            <div class="card-body border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">Pending</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{ $total_pending }}</h2>
                                    Candidates
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-users la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div> --}}

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
      var a = google.visualization.arrayToDataTable([
            [
            "Paper Reports",
            "P1",
            "P2",
            "P3",
            "PE",
            "PA",
            ],
            ["JCHEW", 165, 938, 0, 998, 450, ],
            ["CHEW", 135, 1120, 599, 1268, 288, ],
            ["CHO", 157, 1167, 587, 807, 397, ],
            ["BCHS", 139, 1110, 615, 968, 215, ],
        ]),
        b = {
          chart: {
            title: "Paper Report per Cadre",
            subtitle: "Sales, Expenses, and Profit: 2014-2017",
          },
          bars: "vertical",
          vAxis: {
            format: "decimal",
          },
          height: 260,
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
      var data = google.visualization.arrayToDataTable([
        ["Task", "Hours per Day"],
        ["P1", 5],
        ["P2", 10],
        ["P3", 15],
        ["PE", 20],
        ["PA", 25],
      ]);
      var options = {
        title: "My Daily Activities",
        width: "100%",
        height: 300,
        colors: [
          "#f8d62b",
          "#51bb25",
          "#173878",
          RihoAdminConfig.secondary,
          RihoAdminConfig.primary,
        ],
      };
      var chart = new google.visualization.PieChart(
        document.getElementById("pie-chart1")
      );
      chart.draw(data, options);
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