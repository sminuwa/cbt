<div class="table-responsive">
    <table class="display" id="export-button-sample">
        <thead>
        <tr>
            <th>#</th>
            <th>Exam No.</th>
            <th>Fullname</th>
            <th>P1</th>
            <th>P2</th>
            <th>P3</th>
            <th>PE</th>
            <th>PA</th>
        </tr>
        </thead>
        <tbody>
        @foreach($candidates as $candidate)
            <tr>
                <td>
                    <img class="img-fluid table-avtar" src="{{ $candidate->passport() }}" alt="">
                </td>
                <td>{{$candidate->indexing}}</td>
                <td>{{$candidate->fullname}}</td>
                <td>{{ $candidate->P1 ?? 0 }}</td>
                <td>{{ $candidate->P2 ?? 0 }}</td>
                <td>{{ $candidate->P3 ?? 0 }}</td>
                <td>{{ $candidate->PE ?? 0 }}</td>
                <td>{{ $candidate->PA ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
