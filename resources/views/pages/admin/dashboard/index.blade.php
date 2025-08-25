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
                <span class="f-light f-w-500 f-14">Total Candidates</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_candidates }}</h2>
                        <span class="f-12">Candidates</span>
                    </div>
                    <div class="product-sub bg-success-light">
                        <i class="las la-users la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card o-hidden small-widget">
            <div class="card-body total-project border-l-warning border-3">
                <span class="f-light f-w-500 f-14">Total Programmes</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_programmes }}</h2>
                        <span class="f-12">Programmes</span>
                    </div>
                    <div class="product-sub bg-warning-light">
                        <i class="las la-graduation-cap la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card o-hidden small-widget">
            <div class="card-body total-project border-l-info border-3">
                <span class="f-light f-w-500 f-14">Total Subjects</span>
                <div class="project-details">
                    <div class="project-counter">
                        <h2 class="f-w-600 d-inline">{{ $total_subjects }}</h2>
                        <span class="f-12">Subjects</span>
                    </div>
                    <div class="product-sub bg-info-light">
                        <i class="las la-book la-2x"></i>
                    </div>
                </div>
                @include('components.bubbles')
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->id==1)
<!-- Charts Section -->

<!-- First Row: Candidates Attended per Paper -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Candidates Attended per Paper</h4>
                <span class="f-12 f-light">Number of candidates who attended each paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="candidates-attended-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row: Scheduled Centres per Paper -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Scheduled Centres per Paper/Test Code</h4>
                <span class="f-12 f-light">Number of centres, venues, and schedules per test paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="scheduled-centres-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Third Row: Pull/Push Statistics -->
<div class="row">
    <div class="col-sm-12 col-xl-6 box-col-6">
        <div class="card">
            <div class="card-header">
                <h4>Centres Pull Status</h4>
                <span class="f-12 f-light">Number of centres pulled per paper</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="centres-pulled-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
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
                <div class="chart-overflow" id="centres-pushed-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fourth Row: Attendance Remarks -->
<div class="row">
    <div class="col-sm-12 col-xl-6 box-col-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Attendance Remarks</h4>
                <span class="f-12 f-light">Distribution of attendance remarks</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="attendance-remarks-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fifth Row: Centre Performance -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Centre Performance Statistics</h4>
                <span class="f-12 f-light">Average performance and completion rates by centre</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="centre-performance-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sixth Row: Daily Activity and Subject Performance -->
<div class="row">
    <div class="col-sm-12 col-xl-7 box-col-7">
        <div class="card">
            <div class="card-header">
                <h4>Daily Exam Activity (Last 5 Days)</h4>
                <span class="f-12 f-light">Trend of candidates starting and completing exams</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="daily-activity-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
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
                <div class="chart-overflow" id="subject-performance-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seventh Row: Centre Capacity Utilization -->
<div class="row">
    <div class="col-sm-12 col-xl-12 box-col-12">
        <div class="card">
            <div class="card-header">
                <h4>Centre Capacity Utilization</h4>
                <span class="f-12 f-light">How well centres are being utilized</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="capacity-utilization-chart">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Eighth Row: Exam Status Overview -->
<div class="row">
    <div class="col-sm-12 col-xl-6 box-col-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Exam Status Overview</h4>
                <span class="f-12 f-light">Distribution of exam completion status</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="pie-chart1">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ninth Row: Test Programme Performance and Top Scorers -->
<div class="row">
    <div class="col-sm-12 col-xl-8 box-col-8">
        <div class="card">
            <div class="card-header">
                <h4>Test Programme Performance</h4>
                <span class="f-12 f-light">Candidates and responses by programme</span>
            </div>
            <div class="card-body chart-block">
                <div class="chart-overflow" id="column-chart1">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
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
                <div class="chart-overflow" id="bar-chart1">
                    <div class="chart-loading">
                        <i class="las la-spinner la-3x"></i>
                        <p>Loading chart data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
    
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>Dashboard Summary</h4>
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
                                            <h2 class="f-w-600 d-inline">{{ $total_submitted }}</h2>
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
    
    // Base URLs for API calls
    apiUrls: {
        'scheduled-centres': '{{ route("admin.api.dashboard.scheduled.centres") }}',
        'centres-pull': '{{ route("admin.api.dashboard.centres.pull") }}',
        'centres-push': '{{ route("admin.api.dashboard.centres.push") }}',
        'candidates-attended': '{{ route("admin.api.dashboard.candidates.attended") }}',
        'attendance-stats': '{{ route("admin.api.dashboard.attendance.stats") }}',
        'centre-performance': '{{ route("admin.api.dashboard.centre.performance") }}',
        'daily-activity': '{{ route("admin.api.dashboard.daily.activity") }}',
        'subject-performance': '{{ route("admin.api.dashboard.subject.performance") }}',
        'capacity-utilization': '{{ route("admin.api.dashboard.capacity.utilization") }}',
        'exam-status': '{{ route("admin.api.dashboard.exam.status") }}',
        'test-programme': '{{ route("admin.api.dashboard.test.programme") }}',
        'top-scorers': '{{ route("admin.api.dashboard.top.scorers") }}'
    },
    
    // Initialize all charts
    init() {
        // Wait for Google Charts to load
        google.charts.setOnLoadCallback(() => {
            this.loadAllCharts();
        });
    },
    
    // Load all charts with improved staggered delays for better UX
    loadAllCharts() {
        // Group charts by priority - load most important charts first
        const priorityCharts = [
            { id: 'candidates-attended-chart', endpoint: 'candidates-attended', delay: 0 }, // First chart after overview cards
            { id: 'pie-chart1', endpoint: 'exam-status', delay: 500 },
            { id: 'daily-activity-chart', endpoint: 'daily-activity', delay: 1000 },
            { id: 'attendance-remarks-chart', endpoint: 'attendance-stats', delay: 1500 }
        ];
        
        const mediumCharts = [
            { id: 'scheduled-centres-chart', endpoint: 'scheduled-centres', delay: 2000 },
            { id: 'centres-pulled-chart', endpoint: 'centres-pull', delay: 2500 },
            { id: 'centres-pushed-chart', endpoint: 'centres-push', delay: 3000 },
            { id: 'column-chart1', endpoint: 'test-programme', delay: 3500 }
        ];
        
        const heavyCharts = [
            { id: 'centre-performance-chart', endpoint: 'centre-performance', delay: 4000 },
            { id: 'subject-performance-chart', endpoint: 'subject-performance', delay: 5000 },
            { id: 'capacity-utilization-chart', endpoint: 'capacity-utilization', delay: 6000 },
            { id: 'bar-chart1', endpoint: 'top-scorers', delay: 7000 }
        ];
        
        const allCharts = [...priorityCharts, ...mediumCharts, ...heavyCharts];
        
        allCharts.forEach(chart => {
            setTimeout(() => {
                this.loadChart(chart.id, chart.endpoint);
            }, chart.delay);
        });
    },
    
    // Generic chart loader with improved error handling
    loadChart(chartId, endpoint) {
        if ($("#" + chartId).length === 0) return;
        
        this.loadingStates[chartId] = true;
        
        // Determine timeout based on chart complexity
        const heavyCharts = ['centre-performance', 'subject-performance', 'capacity-utilization', 'top-scorers'];
        const timeout = heavyCharts.includes(endpoint) ? 45000 : 20000;
        
        $.ajax({
            url: this.apiUrls[endpoint],
            method: 'GET',
            dataType: 'json',
            timeout: timeout,
            beforeSend: () => {
                // Show loading indicator specific to the chart type
                this.showLoadingWithProgress(chartId, endpoint);
            },
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
                console.error(`Chart ${chartId} loading failed:`, status, error);
                
                let errorMessage = 'Failed to load chart.';
                if (status === 'timeout') {
                    errorMessage = 'Chart loading timed out. The system may be busy processing data.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error occurred while loading chart data.';
                } else if (xhr.status === 0) {
                    errorMessage = 'Network connection issue. Please check your internet connection.';
                }
                
                this.showError(chartId, errorMessage);
            }
        });
    },
    
    // Show enhanced loading indicator
    showLoadingWithProgress(chartId, endpoint) {
        const heavyCharts = ['centre-performance', 'subject-performance', 'capacity-utilization', 'top-scorers'];
        const isHeavy = heavyCharts.includes(endpoint);
        const message = isHeavy ? 'Processing complex data...' : 'Loading chart data...';
        
        document.getElementById(chartId).innerHTML = 
            `<div class="chart-loading">
                <i class="las la-spinner la-3x"></i>
                <p>${message}</p>
                ${isHeavy ? '<small>This may take a moment for complex datasets</small>' : ''}
            </div>`;
    },
    
    // Show error message with retry option
    showError(chartId, message) {
        document.getElementById(chartId).innerHTML = 
            `<div class="chart-error">
                <i class="las la-exclamation-triangle la-3x mb-3"></i>
                <p>Error loading chart</p>
                <small>${message}</small>
                <div class="mt-3">
                    <button class="btn btn-sm btn-outline-primary" onclick="DashboardCharts.retryChart('${chartId}')">Retry</button>
                </div>
            </div>`;
    },
    
    // Retry loading a specific chart
    retryChart(chartId) {
        // Find the endpoint for this chart
        const chartMappings = {
            'scheduled-centres-chart': 'scheduled-centres',
            'centres-pulled-chart': 'centres-pull',
            'centres-pushed-chart': 'centres-push',
            'candidates-attended-chart': 'candidates-attended',
            'attendance-remarks-chart': 'attendance-stats',
            'centre-performance-chart': 'centre-performance',
            'daily-activity-chart': 'daily-activity',
            'subject-performance-chart': 'subject-performance',
            'capacity-utilization-chart': 'capacity-utilization',
            'pie-chart1': 'exam-status',
            'column-chart1': 'test-programme',
            'bar-chart1': 'top-scorers'
        };
        
        const endpoint = chartMappings[chartId];
        if (endpoint) {
            this.loadChart(chartId, endpoint);
        }
    },
    
    // Show no data message
    showNoData(chartId, message = 'No data available') {
        document.getElementById(chartId).innerHTML = 
            `<div style="display:flex; align-items:center; justify-content:center; height:300px; color:#6c757d; flex-direction:column;">
                <i class="las la-chart-bar la-3x mb-3"></i>
                <p>${message}</p>
                <small>Data will appear when available</small>
            </div>`;
    },
    
    // Render specific chart based on type
    renderChart(chartId, data, endpoint) {
        if (!data || data.length === 0) {
            this.showNoData(chartId);
            return;
        }
        
        try {
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
        } catch (error) {
            console.error('Error rendering chart:', error);
            this.showError(chartId, 'Chart rendering failed');
        }
    },
    
    // Individual chart rendering methods
    renderScheduledCentres(chartId, data) {
        const chartData = [['Paper/Test Code', 'Total Schedules', 'Unique Venues', 'Unique Centres']];
        data.forEach(item => {
            chartData.push([item.paper_name, parseInt(item.total_schedules), parseInt(item.unique_venues), parseInt(item.unique_centres)]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Scheduled Centres per Paper', subtitle: 'Number of schedules, venues, and centres per test paper' },
            bars: 'vertical',
            vAxis: { format: 'decimal' },
            hAxis: { textStyle: { fontSize: 10 } },
            height: 400,
            colors: ['#007bff', '#28a745', '#ffc107']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderCentresPull(chartId, data) {
        const chartData = [['Paper', 'Centres Pulled', 'Candidates Pulled']];
        data.forEach(item => {
            chartData.push([item.paper_name, parseInt(item.centres_pulled), parseInt(item.total_candidates_pulled) || 0]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Centres Pull Status', subtitle: 'Centres and candidates pulled per paper' },
            bars: 'horizontal',
            hAxis: { format: 'decimal' },
            height: 300,
            colors: ['#17a2b8', '#6f42c1']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderCentresPush(chartId, data) {
        const chartData = [['Paper', 'Centres Pushed', 'Candidates Pushed']];
        data.forEach(item => {
            chartData.push([item.paper_name, parseInt(item.centres_pushed), parseInt(item.total_candidates_pushed) || 0]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Centres Push Status', subtitle: 'Centres and candidates pushed per paper' },
            bars: 'horizontal',
            hAxis: { format: 'decimal' },
            height: 300,
            colors: ['#fd7e14', '#e83e8c']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderCandidatesAttended(chartId, data) {
        const chartData = [['Paper', 'Candidates Attended', 'Candidates Completed']];
        data.forEach(item => {
            chartData.push([item.paper_name, parseInt(item.candidates_attended), parseInt(item.candidates_completed)]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Candidates Attended per Paper', subtitle: 'Number of candidates who attended and completed each paper' },
            bars: 'vertical',
            vAxis: { format: 'decimal' },
            height: 350,
            colors: ['#28a745', '#007bff']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderAttendanceRemarks(chartId, data) {
        const chartData = [['Remark', 'Count']];
        data.forEach(item => {
            chartData.push([item.remark || 'No Remark', parseInt(item.count)]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            title: 'Attendance Remarks Distribution',
            width: '100%',
            height: 300,
            pieHole: 0.3,
            colors: ['#28a745', '#dc3545', '#ffc107', '#6c757d', '#17a2b8']
        };
        
        const chart = new google.visualization.PieChart(document.getElementById(chartId));
        chart.draw(dataTable, options);
    },
    
    renderCentrePerformance(chartId, data) {
        const chartData = [['Centre', 'Total Candidates', 'Completed Candidates', 'Average Score', 'Total Responses']];
        data.forEach(item => {
            chartData.push([
                item.centre_name.substring(0, 20),
                parseInt(item.total_candidates),
                parseInt(item.completed_candidates),
                parseFloat(item.average_score) || 0,
                parseInt(item.total_responses)
            ]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Centre Performance Statistics', subtitle: 'Performance metrics by centre' },
            bars: 'vertical',
            vAxis: { format: 'decimal' },
            hAxis: { textStyle: { fontSize: 10 } },
            height: 400,
            colors: ['#007bff', '#28a745', '#dc3545', '#ffc107']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderDailyActivity(chartId, data) {
        const chartData = [['Date', 'Started', 'Completed']];
        data.forEach(item => {
            chartData.push([item.exam_date, parseInt(item.candidates_started), parseInt(item.candidates_completed)]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            title: 'Daily Exam Activity (Last 5 Days)',
            curveType: 'function',
            legend: { position: 'bottom' },
            hAxis: { textStyle: { fontSize: 10 } },
            height: 350,
            colors: ['#007bff', '#28a745']
        };
        
        const chart = new google.visualization.LineChart(document.getElementById(chartId));
        chart.draw(dataTable, options);
    },
    
    renderSubjectPerformance(chartId, data) {
        const chartData = [['Subject', 'Average Score']];
        data.forEach(item => {
            chartData.push([item.subject_code, parseFloat(item.average_score) || 0]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Subject Performance', subtitle: 'Average scores by subject' },
            bars: 'horizontal',
            hAxis: { format: 'decimal', minValue: 0, maxValue: 1 },
            height: 300,
            colors: ['#6f42c1']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderCapacityUtilization(chartId, data) {
        const chartData = [['Centre', 'Utilization %']];
        data.forEach(item => {
            chartData.push([item.centre_name.substring(0, 15), parseFloat(item.utilization_percentage) || 0]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Centre Capacity Utilization', subtitle: 'Percentage of centre capacity being used' },
            bars: 'horizontal',
            hAxis: { format: 'decimal', minValue: 0, maxValue: 100 },
            height: 300,
            colors: ['#fd7e14']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderExamStatus(chartId, data) {
        const chartData = [
            ['Status', 'Count'],
            ['Completed', data.completed],
            ['In Progress', data.in_progress],
            ['Not Started', data.not_started]
        ];
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            title: 'Exam Status Distribution',
            width: '100%',
            height: 300,
            colors: ['#28a745', '#ffc107', '#dc3545'],
            legend: { position: 'bottom', alignment: 'center' },
            pieHole: 0.4
        };
        
        const chart = new google.visualization.PieChart(document.getElementById(chartId));
        chart.draw(dataTable, options);
    },
    
    renderTestProgramme(chartId, data) {
        const chartData = [['Test Programme', 'Candidates', 'Responses']];
        data.forEach(item => {
            chartData.push([item.name, parseInt(item.candidate_count), parseInt(item.total_responses)]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Test Performance by Programme', subtitle: 'Candidates registered and responses submitted' },
            bars: 'horizontal',
            hAxis: { format: 'decimal', title: 'Number of Candidates/Responses' },
            vAxis: { textStyle: { fontSize: 12 } },
            height: 400,
            colors: ['#007bff', '#28a745', '#51bb25', '#173878', '#f8d62b']
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderTopScorers(chartId, data) {
        if (!data || data.length === 0) {
            this.showNoData(chartId, 'No scoring data available yet');
            return;
        }
        
        const chartData = [['Programme', 'Top Score (%)', { role: 'tooltip', type: 'string', p: { html: true } }]];
        data.forEach(item => {
            const cadre = item.cadre.length > 20 ? item.cadre.substring(0, 20) + '...' : item.cadre;
            const tooltip = `<div style="padding:10px"><b>${item.cadre}</b><br/>Top Scorer: ${item.candidate_name}<br/>Exam No: ${item.indexing}<br/>Score: ${item.percentage}% (${item.average_score}/${item.total_questions})</div>`;
            chartData.push([cadre, item.percentage, tooltip]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            chart: { title: 'Top Scorers by Programme', subtitle: 'Highest performing candidate per cadre' },
            bars: 'horizontal',
            hAxis: { format: 'decimal', title: 'Score Percentage (%)', minValue: 0, maxValue: 100 },
            height: 300,
            colors: ['#17a2b8'],
            tooltip: { isHtml: true },
            legend: { position: 'none' }
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    }
};

// Initialize dashboard when page loads
$(document).ready(function() {
    DashboardCharts.init();
});
</script>

@endsection
