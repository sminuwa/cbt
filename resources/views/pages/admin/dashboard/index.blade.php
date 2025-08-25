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
<!-- Charts Section with Consistent Heights -->

<!-- First Row: Key Metrics -->
<div class="row">
    <div class="col-sm-12 col-md-12 col-xl-8">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Candidates Attended per Test Configuration</h5>
                <small class="text-muted">Per test configuration - showing attended, completed, and in progress</small>
            </div>
            <div class="card-body compact-chart">
                <div id="candidates-attended-chart" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Exam Status</h5>
                <small class="text-muted">Completion distribution</small>
            </div>
            <div class="card-body compact-chart">
                <div id="pie-chart1" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row: Centre Operations -->
<div class="row">
    <div class="col-sm-12 col-md-6 col-xl-6">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Centres Pull Status</h5>
                <small class="text-muted">Centres and candidates pulled per paper</small>
            </div>
            <div class="card-body compact-chart">
                <div id="centres-pulled-chart" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-6">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Centres Push Status</h5>
                <small class="text-muted">Centres with candidates who have started exams</small>
            </div>
            <div class="card-body compact-chart">
                <div id="centres-pushed-chart" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Third Row: Daily Activity -->
<div class="row">
    <div class="col-sm-12 col-md-12 col-xl-6">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Daily Activity</h5>
                <small class="text-muted">Last 5 days trend - candidates starting and completing exams</small>
            </div>
            <div class="card-body compact-chart">
                <div id="daily-activity-chart" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-6">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Test Programme Performance</h5>
                <small class="text-muted">Candidates registered and responses submitted by programme</small>
            </div>
            <div class="card-body compact-chart">
                <div id="column-chart1" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fourth Row: Academic Performance -->
<div class="row">
    <div class="col-sm-12 col-md-6 col-xl-6">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Subject Performance</h5>
                <small class="text-muted">Average scores by subject</small>
            </div>
            <div class="card-body compact-chart">
                <div id="subject-performance-chart" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-6">
        <div class="card dashboard-chart-card">
            <div class="card-header compact-header">
                <h5>Top Scorers</h5>
                <small class="text-muted">Highest performers by programme</small>
            </div>
            <div class="card-body compact-chart">
                <div id="bar-chart1" class="chart-container">
                    <div class="chart-loading">
                        <i class="las la-spinner la-2x"></i>
                        <p>Loading...</p>
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
/* Dashboard Chart Styling */
.dashboard-chart-card {
    height: 345px;
    margin-bottom: 20px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.compact-header {
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
    background-color: #f8f9fa;
}

.compact-header h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #495057;
}

.compact-header small {
    font-size: 12px;
    color: #6c757d;
    margin-top: 2px;
    display: block;
}

.compact-chart {
    padding: 8px;
    height: calc(345px - 65px); /* Total height minus header */
    overflow: hidden;
}

.chart-container {
    height: 100%;
    width: 100%;
}

.chart-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    flex-direction: column;
    color: #6c757d;
}

.chart-loading i {
    animation: spin 2s linear infinite;
    margin-bottom: 10px;
}

.chart-loading p {
    margin: 0;
    font-size: 12px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.chart-error {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    flex-direction: column;
    color: #dc3545;
    font-size: 12px;
    text-align: center;
    padding: 10px;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .dashboard-chart-card {
        height: 380px;
    }
    .compact-chart {
        height: calc(380px - 65px);
    }
}

@media (max-width: 768px) {
    .dashboard-chart-card {
        height: 400px;
        margin-bottom: 15px;
    }
    .compact-chart {
        height: calc(400px - 65px);
    }
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
            { id: 'daily-activity-chart', endpoint: 'daily-activity', delay: 1000 }
        ];
        
        const mediumCharts = [
            { id: 'centres-pulled-chart', endpoint: 'centres-pull', delay: 2000 },
            { id: 'centres-pushed-chart', endpoint: 'centres-push', delay: 2500 },
            { id: 'column-chart1', endpoint: 'test-programme', delay: 3000 }
        ];
        
        const heavyCharts = [
            { id: 'subject-performance-chart', endpoint: 'subject-performance', delay: 4000 },
            { id: 'bar-chart1', endpoint: 'top-scorers', delay: 5000 }
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
        const heavyCharts = ['subject-performance', 'top-scorers'];
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
                console.log(`API Response for ${chartId}:`, response);
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
        const heavyCharts = ['subject-performance', 'top-scorers'];
        const isHeavy = heavyCharts.includes(endpoint);
        const message = isHeavy ? 'Processing...' : 'Loading...';
        
        document.getElementById(chartId).innerHTML = 
            `<div class="chart-loading">
                <i class="las la-spinner la-2x"></i>
                <p>${message}</p>
                ${isHeavy ? '<small>Complex data</small>' : ''}
            </div>`;
    },
    
    // Show error message with retry option
    showError(chartId, message) {
        document.getElementById(chartId).innerHTML = 
            `<div class="chart-error">
                <i class="las la-exclamation-triangle la-2x mb-2"></i>
                <p><strong>Error loading chart</strong></p>
                <small>${message}</small>
                <div class="mt-2">
                    <button class="btn btn-xs btn-outline-primary" onclick="DashboardCharts.retryChart('${chartId}')">Retry</button>
                </div>
            </div>`;
    },
    
    // Retry loading a specific chart
    retryChart(chartId) {
        // Find the endpoint for this chart
        const chartMappings = {
            'centres-pulled-chart': 'centres-pull',
            'centres-pushed-chart': 'centres-push',
            'candidates-attended-chart': 'candidates-attended',
            'daily-activity-chart': 'daily-activity',
            'subject-performance-chart': 'subject-performance',
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
            `<div style="display:flex; align-items:center; justify-content:center; height:100%; color:#6c757d; flex-direction:column; font-size:12px; text-align:center; padding:10px;">
                <i class="las la-chart-bar la-2x mb-2"></i>
                <p style="margin:5px 0;">${message}</p>
                <small>Data will appear when available</small>
            </div>`;
    },
    
    // Render specific chart based on type
    renderChart(chartId, data, endpoint) {
        // Log for debugging
        console.log(`Rendering chart ${chartId} with endpoint ${endpoint}:`, data);
        
        if (!data || data.length === 0) {
            this.showNoData(chartId, `No ${endpoint.replace('-', ' ')} data available`);
            return;
        }
        
        try {
            switch(endpoint) {
                case 'centres-pull':
                    this.renderCentresPull(chartId, data);
                    break;
                case 'centres-push':
                    this.renderCentresPush(chartId, data);
                    break;
                case 'candidates-attended':
                    this.renderCandidatesAttended(chartId, data);
                    break;
                case 'daily-activity':
                    this.renderDailyActivity(chartId, data);
                    break;
                case 'subject-performance':
                    this.renderSubjectPerformance(chartId, data);
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
            this.showError(chartId, 'Chart rendering failed: ' + error.message);
        }
    },
    
    // Individual chart rendering methods
    
    renderCentresPull(chartId, data) {
        // Check if data is empty or null
        if (!data || data.length === 0) {
            this.showNoData(chartId, 'No pull status data available');
            return;
        }
        
        const chartData = [['Paper', 'Centres Pulled', 'Candidates Pulled']];
        data.forEach(item => {
            chartData.push([item.paper_name, parseInt(item.centres_pulled), parseInt(item.total_candidates_pulled) || 0]);
        });
        
        // Double check if we actually have data rows
        if (chartData.length === 1) {
            this.showNoData(chartId, 'No pull status data available');
            return;
        }
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            bars: 'horizontal',
            hAxis: { format: 'decimal' },
            height: '100%',
            width: '100%',
            colors: ['#17a2b8', '#6f42c1'],
            legend: { position: 'none' },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 12,
                    bold: true,
                    color: '#333'
                }
            },
            bar: { groupWidth: '75%' },
            chartArea: { left: 120, top: 20, width: '70%', height: '80%' }
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderCentresPush(chartId, data) {
        // Check if data is empty or null
        if (!data || data.length === 0) {
            this.showNoData(chartId, 'No push status data available');
            return;
        }
        
        const chartData = [['Paper', 'Centres Pushed', 'Candidates Pushed']];
        data.forEach(item => {
            chartData.push([item.paper_name, parseInt(item.centres_pushed), parseInt(item.total_candidates_pushed) || 0]);
        });
        
        // Double check if we actually have data rows
        if (chartData.length === 1) {
            this.showNoData(chartId, 'No push status data available');
            return;
        }
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            bars: 'horizontal',
            hAxis: { format: 'decimal' },
            height: '100%',
            width: '100%',
            colors: ['#fd7e14', '#e83e8c'],
            legend: { position: 'none' },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 12,
                    bold: true,
                    color: '#333'
                }
            },
            bar: { groupWidth: '75%' },
            chartArea: { left: 120, top: 20, width: '70%', height: '80%' }
        };
        
        const chart = new google.charts.Bar(document.getElementById(chartId));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));
    },
    
    renderCandidatesAttended(chartId, data) {
        const chartData = [['Paper/Test Code', 'Attended', 'Completed', 'In Progress']];
        data.forEach(item => {
            // Use the combined paper_test_code or fallback to paper_name
            const displayName = item.paper_test_code || item.paper_name;
            chartData.push([
                displayName.length > 25 ? displayName.substring(0, 25) + '...' : displayName,
                parseInt(item.candidates_attended) || 0,
                parseInt(item.candidates_completed) || 0,
                parseInt(item.candidates_in_progress) || 0
            ]);
        });
        
        const dataTable = google.visualization.arrayToDataTable(chartData);
        const options = {
            bars: 'vertical',
            vAxis: { format: 'decimal' },
            hAxis: { textStyle: { fontSize: 9 } },
            height: '100%',
            width: '100%',
            colors: ['#28a745', '#007bff', '#ffc107'],
            legend: { position: 'bottom', alignment: 'center' },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 11,
                    bold: true,
                    color: '#333'
                }
            },
            bar: { groupWidth: '80%' },
            chartArea: { left: 50, top: 20, width: '85%', height: '70%' }
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
            curveType: 'function',
            hAxis: { textStyle: { fontSize: 10 } },
            height: '100%',
            width: '100%',
            colors: ['#007bff', '#28a745'],
            legend: { position: 'bottom', alignment: 'center' },
            pointSize: 8,
            dataOpacity: 0.8,
            chartArea: { left: 60, top: 20, width: '85%', height: '70%' },
            annotations: {
                textStyle: {
                    fontSize: 11,
                    bold: true,
                    color: '#333'
                }
            }
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
            bars: 'horizontal',
            hAxis: { format: 'decimal', minValue: 0, maxValue: 1 },
            height: '100%',
            width: '100%',
            colors: ['#6f42c1'],
            legend: { position: 'none' },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 11,
                    bold: true,
                    color: '#333'
                }
            },
            bar: { groupWidth: '70%' },
            chartArea: { left: 80, top: 20, width: '75%', height: '80%' }
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
            width: '100%',
            height: '100%',
            colors: ['#28a745', '#ffc107', '#dc3545'],
            pieHole: 0.4,
            legend: { position: 'bottom', alignment: 'center' },
            pieSliceText: 'value',
            pieSliceTextStyle: {
                color: 'white',
                fontSize: 12,
                bold: true
            },
            chartArea: { left: 20, top: 20, width: '90%', height: '70%' }
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
            bars: 'horizontal',
            hAxis: { format: 'decimal' },
            vAxis: { textStyle: { fontSize: 12 } },
            height: '100%',
            width: '100%',
            colors: ['#007bff', '#28a745', '#51bb25', '#173878', '#f8d62b'],
            legend: { position: 'bottom', alignment: 'center' },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 11,
                    bold: true,
                    color: '#333'
                }
            },
            bar: { groupWidth: '75%' },
            chartArea: { left: 100, top: 20, width: '70%', height: '60%' }
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
            bars: 'horizontal',
            hAxis: { format: 'decimal', minValue: 0, maxValue: 100 },
            height: '100%',
            width: '100%',
            colors: ['#17a2b8'],
            tooltip: { isHtml: true },
            legend: { position: 'none' },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 11,
                    bold: true,
                    color: '#333'
                }
            },
            bar: { groupWidth: '70%' },
            chartArea: { left: 120, top: 20, width: '70%', height: '80%' }
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
