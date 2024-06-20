@if(isset($user))
    <table style="width: 50%;" class="table">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <tr class="primary" style="border-bottom: 0px solid rgba(0,0,0,0) !important;">
            <td>User Number:</td>
            <td>{{ $user->personnel_no }}</td>
        </tr>
        <tr style="border-bottom: 0px solid rgba(0,0,0,0) !important;">
            <td>Full Name:</td>
            <td>{{ $user->display_name }}</td>
        </tr>
        <tr style="border-bottom: 0px solid rgba(0,0,0,0) !important;">
            <td>Subject(s):</td>
            <td>
                <table class="table table-bordered">
                    @foreach($subjects as $subject)
                        <tr>
                            <td>
                                <input type="checkbox" name="subjects[]" value="{{ $subject->subject->id }}">
                                {{ $subject->subject->subject_code }} - {{ $subject->subject->name }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                <input class="btn btn-sm btn-info text-light mt-3 mb-3" type="submit" value="Submit">
            </td>
        </tr>
    </table>
@endif
