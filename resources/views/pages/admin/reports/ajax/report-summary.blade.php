<div class="table-responsive">
    <table id="report" class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Indexing</th>
            <th>Candidate Name</th>
            <th>Paper Code</th>
            <th>Score</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reports as $report)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$report->indexing}}</td>
                <td>{{$report->name}}</td>
                <td>{{$report->subject_code}}</td>
                <td>{{number_format($report->score * $report->aggregate, 2)}}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
