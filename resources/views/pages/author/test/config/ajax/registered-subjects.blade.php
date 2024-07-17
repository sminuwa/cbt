@if(count($subjects))
    <table style="width: 70%" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th style="width: 10%">#</th>
            <th>Code</th>
            <th>Name</th>
            <th style="width: 20%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects as $registered)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $registered->subject->subject_code }}</td>
                <td>{{ $registered->subject->name }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-danger remove" data-id="{{ $registered->id }}" href="javascript:;">
                        Remove
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div style="width:100%;height: 100px;display: flex;justify-content: center;align-items: center">
        No paper registered
    </div>
@endif
