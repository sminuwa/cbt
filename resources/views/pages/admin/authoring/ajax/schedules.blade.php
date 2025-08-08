@if(count($schedules))
    <table class="table table-bordered table-striped mt-2">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Venue</th>
            <th>Batches</th>
            <th>Capacity</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Vacancy</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($schedules as $schedule)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$schedule->date}}</td>
                <td>{{$schedule->venue->name}}</td>
                <td>{{$schedule->maximum_batch}}</td>
                <td>{{$schedule->no_per_schedule}}</td>
                <td>{{$schedule->daily_start_time}}</td>
                <td>{{$schedule->daily_end_time}}</td>
                <td>{{$schedule->venue->capacity}}</td>
                <td>
                    @if($schedule->venue->capacity>$size)
                        <input class="selection" type='radio' name='schedule' value='{{$schedule->id }}'>
                    @else
                        Occupied
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="p-4">
        <a id="reschedule" class="btn btn-sm btn-info text-light float-end mb-3" href="javascript:;"
           data-id="{{$schedule_id}}" style="display: none">Reschedule</a>
    </div>
@else
    <div class="d-flex justify-content-center p-4" style="width: 100%; height: 80px;">
        No other schedule available
    </div>
@endif
