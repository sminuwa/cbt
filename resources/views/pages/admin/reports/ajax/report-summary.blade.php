<div class="table-responsive">
    <table id="report" class="table table-bordered table-stripped table-condensed">
        <thead>
        <tr>
            <th>#</th>
            <th>Indexing</th>
            <th>Surname</th>
            <th>First Name</th>
            <th>Other Name(s)</th>
            {{-- <th>Paper Code</th> --}}
            @foreach ($subjects as $subject)
                <th>{{ $subject }}</th>
            @endforeach
            {{-- <th>Action</th> --}}
        </tr>
        </thead>
        <tbody>
        @foreach($reports as $report)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$report['indexing']}}</td>
                <td>{{$report['surname']}}</td>
                <td>{{$report['firstname']}}</td>
                <td>{{$report['other_names']}}</td>
                {{-- <td>{{$report->subject_code}}</td> --}}
                @foreach ($subjects as $subject)
                  <td>{{ $report[$subject] }}</td>
                @endforeach
                {{-- <td>{{number_format($report->score * $report->aggregate, 2)}}</td> --}}
                {{-- <td></td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
