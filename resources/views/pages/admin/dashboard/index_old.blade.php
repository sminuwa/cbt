@extends('layouts.app')

@section('content')
<!-- System Overview Cards -->
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card o-hidden small-widget">
            <div class="card-body total-project border-l-primary border-3">
                <span class="f-light f-w-500 f-14">Total Centres</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_centres }}</h2>
                        <span class="f-12">Centres</span>
                    </div>
                    <div class="product-sub bg-primary-light">
                        <i class="las la-building la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card o-hidden small-widget">
            <div class="card-body total-project border-l-success border-3">
                <span class="f-light f-w-500 f-14">Total Venues</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_venues }}</h2>
                        <span class="f-12">Venues</span>
                    </div>
                    <div class="product-sub bg-success-light">
                        <i class="las la-map-marker la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card o-hidden small-widget">
            <div class="card-body total-project border-l-warning border-3">
                <span class="f-light f-w-500 f-14">Total Schedules</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_schedules }}</h2>
                        <span class="f-12">Schedules</span>
                    </div>
                    <div class="product-sub bg-warning-light">
                        <i class="las la-calendar la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card o-hidden small-widget">
            <div class="card-body total-project border-l-info border-3">
                <span class="f-light f-w-500 f-14">Total Attendances</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_attendances }}</h2>
                        <span class="f-12">Attendances</span>
                    </div>
                    <div class="product-sub bg-info-light">
                        <i class="las la-user-check la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->id==1)
<!-- First Row: Scheduled Centres per Paper -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Scheduled Centres per Paper/Test Code</h4>
                <span class="f-12 f-light">Number of centres, venues, and schedules per test paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="scheduled-centres-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row: Pull/Push Statistics -->
<div class="row">
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
            <div class="card-header">
                <h4>Centres Pull Status</h4>
                <span class="f-12 f-light">Number of centres pulled per paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="centres-pulled-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
            <div class="card-header">
                <h4>Centres Push Status</h4>
                <span class="f-12 f-light">Number of centres pushed per paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="centres-pushed-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Third Row: Candidates Attendance -->
<div class="row">
    <div class="col-sm-12 col-xl-8 box-col-8">
        <div class="card">
            <div class="card-header">
                <h4>Candidates Attended per Paper</h4>
                <span class="f-12 f-light">Number of candidates who attended each paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="candidates-attended-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-4 box-col-4">
        <div class="card">
            <div class="card-header">
                <h4>Attendance Remarks</h4>
                <span class="f-12 f-light">Distribution of attendance remarks</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="attendance-remarks-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Fourth Row: Centre Performance -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Centre Performance Statistics</h4>
                <span class="f-12 f-light">Average performance and completion rates by centre</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="centre-performance-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Fifth Row: Daily Activity and Subject Performance -->
<div class="row">
    <div class="col-sm-12 col-xl-7 box-col-7">
        <div class="card">
            <div class="card-header">
                <h4>Daily Exam Activity (Last 5 Days)</h4>
                <span class="f-12 f-light">Trend of candidates starting and completing exams</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="daily-activity-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-5 box-col-5">
        <div class="card">
            <div class="card-header">
                <h4>Subject Performance</h4>
                <span class="f-12 f-light">Average scores by subject</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="subject-performance-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Sixth Row: Centre Capacity Utilization -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Centre Capacity Utilization</h4>
                <span class="f-12 f-light">How well centres are being utilized</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="capacity-utilization-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Exam Status Overview Row -->
<div class="row">
    <div class="col-sm-12 col-xl-6 box-col-6 mx-auto">
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
</div>

<!-- Seventh Row: Test Programme Performance and Top Scorers -->
<div class="row">
    <div class="col-sm-12 col-xl-8 box-col-8">
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
    <div class="col-sm-12 col-xl-4 box-col-4">
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
<style>
.chart-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 300px;
    flex-direction: column;
    color: #6c757d;
}

.chart-loading i {
    animation: spin 2s linear infinite;
    margin-bottom: 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.chart-error {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 300px;
    flex-direction: column;
    color: #dc3545;
}
</style>

<script>
// Load Google Charts
google.charts.load("current", { packages: ["corechart", "bar", "line"] });

// Dashboard Chart Loader Object
const DashboardCharts = {
    // Chart loading states
    loadingStates: {},
    
    // Base URL for API calls
    apiBase: '{{ route("admin.api.dashboard.scheduled.centres") }}',
    
    // Initialize all charts
    init() {
        // Wait for Google Charts to load
        google.charts.setOnLoadCallback(() => {
            this.loadAllCharts();
        });
    },
    
    // Load all charts with staggered delays for better UX
    loadAllCharts() {
        const charts = [
            { id: 'scheduled-centres-chart', endpoint: 'scheduled-centres', delay: 0 },
            { id: 'centres-pulled-chart', endpoint: 'centres-pull', delay: 200 },
            { id: 'centres-pushed-chart', endpoint: 'centres-push', delay: 400 },
            { id: 'candidates-attended-chart', endpoint: 'candidates-attended', delay: 600 },
            { id: 'attendance-remarks-chart', endpoint: 'attendance-stats', delay: 800 },
            { id: 'centre-performance-chart', endpoint: 'centre-performance', delay: 1000 },
            { id: 'daily-activity-chart', endpoint: 'daily-activity', delay: 1200 },
            { id: 'subject-performance-chart', endpoint: 'subject-performance', delay: 1400 },
            { id: 'capacity-utilization-chart', endpoint: 'capacity-utilization', delay: 1600 },
            { id: 'pie-chart1', endpoint: 'exam-status', delay: 1800 },
            { id: 'column-chart1', endpoint: 'test-programme', delay: 2000 },
            { id: 'bar-chart1', endpoint: 'top-scorers', delay: 2200 }
        ];
        
        charts.forEach(chart => {
            setTimeout(() => {
                this.loadChart(chart.id, chart.endpoint);
            }, chart.delay);
        });
    },
    
    // Generic chart loader
    loadChart(chartId, endpoint) {
        if ($("#" + chartId).length === 0) return;
        
        this.loadingStates[chartId] = true;
        
        // Get API URL
        const apiUrl = this.apiBase.replace('scheduled-centres', endpoint);
        
        $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            timeout: 30000,
            success: (response) => {
                this.loadingStates[chartId] = false;
                if (response.success) {
                    this.renderChart(chartId, response.data, endpoint);
                } else {
                    this.showError(chartId, response.error || 'Failed to load chart data');
                }
            },
            error: (xhr, status, error) => {
                this.loadingStates[chartId] = false;
                console.error(`Chart ${chartId} loading failed:`, error);
                this.showError(chartId, 'Failed to load chart. Please refresh the page.');
            }
        });
    },
    
    // Render specific chart based on type
    renderChart(chartId, data, endpoint) {
        switch(endpoint) {
            case 'scheduled-centres':
                this.renderScheduledCentres(chartId, data);
                break;
            case 'centres-pull':
                this.renderCentresPull(chartId, data);
                break;
            case 'centres-push':
                this.renderCentresPush(chartId, data);
                break;
            case 'candidates-attended':
                this.renderCandidatesAttended(chartId, data);
                break;
            case 'attendance-stats':
                this.renderAttendanceRemarks(chartId, data);
                break;
            case 'centre-performance':
                this.renderCentrePerformance(chartId, data);
                break;
            case 'daily-activity':
                this.renderDailyActivity(chartId, data);
                break;
            case 'subject-performance':
                this.renderSubjectPerformance(chartId, data);
                break;
            case 'capacity-utilization':
                this.renderCapacityUtilization(chartId, data);
                break;
            case 'exam-status':
                this.renderExamStatus(chartId, data);
                break;
            case 'test-programme':
                this.renderTestProgramme(chartId, data);
                break;
            case 'top-scorers':
                this.renderTopScorers(chartId, data);
                break;
        }
    },
    
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
    
    // NEW COMPREHENSIVE CHARTS
    
    // 1. Scheduled Centres per Paper Chart
    if ($("#scheduled-centres-chart").length > 0) {
      @if(count($scheduled_centres_per_paper) > 0)
      var scheduledCentresData = [
        ['Paper/Test Code', 'Total Schedules', 'Unique Venues', 'Unique Centres']
        @foreach($scheduled_centres_per_paper as $data)
          ,['{{ $data->paper_name }}', {{ $data->total_schedules }}, {{ $data->unique_venues }}, {{ $data->unique_centres }}]
        @endforeach
      ];
      
      var scheduledCentresChartData = google.visualization.arrayToDataTable(scheduledCentresData);
      
      var scheduledCentresOptions = {
        chart: {
          title: 'Scheduled Centres per Paper',
          subtitle: 'Number of schedules, venues, and centres per test paper'
        },
        bars: 'vertical',
        vAxis: { format: 'decimal' },
        hAxis: { textStyle: { fontSize: 10 } },
        height: 400,
        colors: ['#007bff', '#28a745', '#ffc107']
      };
      
      var scheduledCentresChart = new google.charts.Bar(document.getElementById('scheduled-centres-chart'));
      scheduledCentresChart.draw(scheduledCentresChartData, google.charts.Bar.convertOptions(scheduledCentresOptions));
      @else
      document.getElementById('scheduled-centres-chart').innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:400px; color:#6c757d; flex-direction:column;"><i class="las la-chart-bar la-3x mb-3"></i><p>No scheduled centres data available</p><small>Data will appear when tests are scheduled</small></div>';
      @endif
    }
    
    // 2. Centres Pulled Chart
    if ($("#centres-pulled-chart").length > 0) {
      @if(count($centres_pulled_stats) > 0)
      var centresPulledData = [
        ['Paper', 'Centres Pulled', 'Candidates Pulled']
        @foreach($centres_pulled_stats as $data)
          ,['{{ $data->paper_name }}', {{ $data->centres_pulled }}, {{ $data->total_candidates_pulled }}]
        @endforeach
      ];
      
      var centresPulledChartData = google.visualization.arrayToDataTable(centresPulledData);
      
      var centresPulledOptions = {
        chart: {
          title: 'Centres Pull Status',
          subtitle: 'Centres and candidates pulled per paper'
        },
        bars: 'horizontal',
        hAxis: { format: 'decimal' },
        height: 300,
        colors: ['#17a2b8', '#6f42c1']
      };
      
      var centresPulledChart = new google.charts.Bar(document.getElementById('centres-pulled-chart'));
      centresPulledChart.draw(centresPulledChartData, google.charts.Bar.convertOptions(centresPulledOptions));
      @else
      document.getElementById('centres-pulled-chart').innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:300px; color:#6c757d; flex-direction:column;"><i class="las la-download la-3x mb-3"></i><p>No centres pulled data available</p><small>Data will appear when centres are pulled</small></div>';
      @endif
    }
    
    // 3. Centres Pushed Chart
    if ($("#centres-pushed-chart").length > 0) {
      @if(count($centres_pushed_stats) > 0)
      var centresPushedData = [
        ['Paper', 'Centres Pushed', 'Candidates Pushed']
        @foreach($centres_pushed_stats as $data)
          ,['{{ $data->paper_name }}', {{ $data->centres_pushed }}, {{ $data->total_candidates_pushed }}]
        @endforeach
      ];
      
      var centresPushedChartData = google.visualization.arrayToDataTable(centresPushedData);
      
      var centresPushedOptions = {
        chart: {
          title: 'Centres Push Status',
          subtitle: 'Centres and candidates pushed per paper'
        },
        bars: 'horizontal',
        hAxis: { format: 'decimal' },
        height: 300,
        colors: ['#fd7e14', '#e83e8c']
      };
      
      var centresPushedChart = new google.charts.Bar(document.getElementById('centres-pushed-chart'));
      centresPushedChart.draw(centresPushedChartData, google.charts.Bar.convertOptions(centresPushedOptions));
      @else
      document.getElementById('centres-pushed-chart').innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:300px; color:#6c757d; flex-direction:column;"><i class="las la-upload la-3x mb-3"></i><p>No centres pushed data available</p><small>Data will appear when centres are pushed</small></div>';
      @endif
    }
    
    // 4. Candidates Attended Chart
    if ($("#candidates-attended-chart").length > 0) {
      @if(count($candidates_attended_per_paper) > 0)
      var candidatesAttendedData = [
        ['Paper', 'Candidates Attended', 'Candidates Completed']
        @foreach($candidates_attended_per_paper as $data)
          ,['{{ $data->paper_name }}', {{ $data->candidates_attended }}, {{ $data->candidates_completed }}]
        @endforeach
      ];
      
      var candidatesAttendedChartData = google.visualization.arrayToDataTable(candidatesAttendedData);
      
      var candidatesAttendedOptions = {
        chart: {
          title: 'Candidates Attended per Paper',
          subtitle: 'Number of candidates who attended and completed each paper'
        },
        bars: 'vertical',
        vAxis: { format: 'decimal' },
        height: 350,
        colors: ['#28a745', '#007bff']
      };
      
      var candidatesAttendedChart = new google.charts.Bar(document.getElementById('candidates-attended-chart'));
      candidatesAttendedChart.draw(candidatesAttendedChartData, google.charts.Bar.convertOptions(candidatesAttendedOptions));
      @else
      document.getElementById('candidates-attended-chart').innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:350px; color:#6c757d; flex-direction:column;"><i class="las la-user-check la-3x mb-3"></i><p>No candidate attendance data available</p><small>Data will appear when candidates attend exams</small></div>';
      @endif
    }
    
    // 5. Attendance Remarks Pie Chart
    if ($("#attendance-remarks-chart").length > 0) {
      @if(count($attendance_stats) > 0)
      var attendanceRemarksData = [
        ['Remark', 'Count']
        @foreach($attendance_stats as $data)
          ,['{{ $data->remark ?: "No Remark" }}', {{ $data->count }}]
        @endforeach
      ];
      
      var attendanceRemarksChartData = google.visualization.arrayToDataTable(attendanceRemarksData);
      
      var attendanceRemarksOptions = {
        title: 'Attendance Remarks Distribution',
        width: '100%',
        height: 300,
        pieHole: 0.3,
        colors: ['#28a745', '#dc3545', '#ffc107', '#6c757d', '#17a2b8']
      };
      
      var attendanceRemarksChart = new google.visualization.PieChart(document.getElementById('attendance-remarks-chart'));
      attendanceRemarksChart.draw(attendanceRemarksChartData, attendanceRemarksOptions);
      @else
      document.getElementById('attendance-remarks-chart').innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:300px; color:#6c757d; flex-direction:column;"><i class="las la-comment la-3x mb-3"></i><p>No attendance remarks available</p><small>Data will appear when attendance is recorded</small></div>';
      @endif
    }
    
    // 6. Centre Performance Chart
    if ($("#centre-performance-chart").length > 0) {
      var centrePerformanceData = [
        ['Centre', 'Total Candidates', 'Completed Candidates', 'Average Score', 'Total Responses']
        @foreach($centre_performance as $data)
          ,['{{ substr($data->centre_name, 0, 20) }}', {{ $data->total_candidates }}, {{ $data->completed_candidates }}, {{ $data->average_score ?: 0 }}, {{ $data->total_responses }}]
        @endforeach
      ];
      
      var centrePerformanceChartData = google.visualization.arrayToDataTable(centrePerformanceData);
      
      var centrePerformanceOptions = {
        chart: {
          title: 'Centre Performance Statistics',
          subtitle: 'Performance metrics by centre'
        },
        bars: 'vertical',
        vAxis: { format: 'decimal' },
        hAxis: { textStyle: { fontSize: 10 } },
        height: 400,
        colors: ['#007bff', '#28a745', '#dc3545', '#ffc107']
      };
      
      var centrePerformanceChart = new google.charts.Bar(document.getElementById('centre-performance-chart'));
      centrePerformanceChart.draw(centrePerformanceChartData, google.charts.Bar.convertOptions(centrePerformanceOptions));
    }
    
    // 7. Daily Activity Line Chart
    if ($("#daily-activity-chart").length > 0) {
      var dailyActivityData = [
        ['Date', 'Started', 'Completed']
        @foreach($daily_activity as $data)
          ,['{{ $data->exam_date }}', {{ $data->candidates_started }}, {{ $data->candidates_completed }}]
        @endforeach
      ];
      
      var dailyActivityChartData = google.visualization.arrayToDataTable(dailyActivityData);
      
      var dailyActivityOptions = {
        chart: {
          title: 'Daily Exam Activity (Last 5 Days)',
          subtitle: 'Trend of candidates starting and completing exams'
        },
        curveType: 'function',
        legend: { position: 'bottom' },
        hAxis: { textStyle: { fontSize: 10 } },
        height: 350,
        colors: ['#007bff', '#28a745']
      };
      
      var dailyActivityChart = new google.visualization.LineChart(document.getElementById('daily-activity-chart'));
      dailyActivityChart.draw(dailyActivityChartData, dailyActivityOptions);
    }
    
    // 8. Subject Performance Chart
    if ($("#subject-performance-chart").length > 0) {
      var subjectPerformanceData = [
        ['Subject', 'Average Score']
        @foreach($subject_performance_detailed as $data)
          ,['{{ $data->subject_code }}', {{ $data->average_score ?: 0 }}]
        @endforeach
      ];
      
      var subjectPerformanceChartData = google.visualization.arrayToDataTable(subjectPerformanceData);
      
      var subjectPerformanceOptions = {
        chart: {
          title: 'Subject Performance',
          subtitle: 'Average scores by subject'
        },
        bars: 'horizontal',
        hAxis: { format: 'decimal', minValue: 0, maxValue: 1 },
        height: 300,
        colors: ['#6f42c1']
      };
      
      var subjectPerformanceChart = new google.charts.Bar(document.getElementById('subject-performance-chart'));
      subjectPerformanceChart.draw(subjectPerformanceChartData, google.charts.Bar.convertOptions(subjectPerformanceOptions));
    }
    
    // 9. Centre Capacity Utilization Chart
    if ($("#capacity-utilization-chart").length > 0) {
      var capacityUtilizationData = [
        ['Centre', 'Utilization %']
        @foreach($centre_capacity_utilization as $data)
          ,['{{ substr($data->centre_name, 0, 15) }}', {{ $data->utilization_percentage ?: 0 }}]
        @endforeach
      ];
      
      var capacityUtilizationChartData = google.visualization.arrayToDataTable(capacityUtilizationData);
      
      var capacityUtilizationOptions = {
        chart: {
          title: 'Centre Capacity Utilization',
          subtitle: 'Percentage of centre capacity being used'
        },
        bars: 'horizontal',
        hAxis: { format: 'decimal', minValue: 0, maxValue: 100 },
        height: 300,
        colors: ['#fd7e14']
      };
      
      var capacityUtilizationChart = new google.charts.Bar(document.getElementById('capacity-utilization-chart'));
      capacityUtilizationChart.draw(capacityUtilizationChartData, google.charts.Bar.convertOptions(capacityUtilizationOptions));
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