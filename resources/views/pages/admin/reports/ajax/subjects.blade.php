<option value="">Select Subject</option>
@if(count($subjects) > 1)
    <option value="%">All Subjects</option>
@endif
@foreach($subjects as $subject)
    <option value="{{$subject->subject_id}}">{{$subject->subject->subject_code}} - {{$subject->subject->name}}</option>
@endforeach
