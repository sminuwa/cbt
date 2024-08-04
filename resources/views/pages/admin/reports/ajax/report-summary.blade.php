<div class="table-responsive">
    @if(count($reports)>0)
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
    @else
        <div class="card border-info">
            <div class="card-header">
                <h4 class="card-title">&nbsp;</h4>
            </div>
            <div class="card-body pt-2 pb-2  mt-1 mb-1">
                <div class="row">
                    <div class="row pb-5 pt-5">
                        <p class="text-center"> No record found</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
