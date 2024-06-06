@if(count($reports)>0)
    <table id="report" class="datatable table table-hover table-center mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Exam Number</th>
            <th>Surname</th>
            <th>First Name</th>
            <th>Other Name</th>
            <th>Programme</th>
            <th>Score</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reports as $report)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $report->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
