@foreach($candidates as $candidate)
    <option value="{{$candidate->id}}">{{$candidate->indexing}}
        - {{strtoupper($candidate->surname)}} {{$candidate->firstname}} {{$candidate->other_names}}</option>
@endforeach
