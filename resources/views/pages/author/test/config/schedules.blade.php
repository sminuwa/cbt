@php use App\Models\Centre;use App\Models\ExamsDate;use App\Models\Scheduling;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @if(session()->has('success'))
        @if(!session('success'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endif
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Test Schedules</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-lg-12 col-xl-12 col-md-6">
            <div class="card border-info">
                <div class="card-header border-info">
                    New Schedule
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.test.config.schedules.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        <input type="hidden" name="id" id="schedule_id">
                        <div class="row">
                            <div class="col-md-12 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label for="exam-dates">Test Date:</label>
                                    <select class="form-control form-select" id="exam-dates" name="date" required>
                                        @php
                                            $dates = ExamsDate::where(['test_config_id'=>$config_id])->get();
                                        @endphp
                                        <option value="0">---</option>
                                        @foreach($dates as $date)
                                            <option value="{{$date->date}}">
                                                {{ Carbon::parse($date->date)->format('D, jS M, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="centre-div" class="col-12 col-md-12 col-lg-3 col-xl-3" style="display: none">
                                <div class="form-group">
                                    <label for="availability">Institution/Centre:</label>
                                    @php
                                        $centres=Centre::all();
                                    @endphp
                                    <select class="form-control form-select" id="centre" required>
                                        <option value="0">---</option>
                                        @foreach($centres as $centre)
                                            <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="venue-div" class="col-12 col-md-12 col-lg-3 col-xl-3" style="display: none">
                                <div class="form-group">
                                    <label for="venue">Venue:</label>
                                    <select class="form-control form-select" name="venue_id" id="venue" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="batches-div" class="row mt-3" style="display: none">
                            <div class="col-md-12 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label for="maximum_batch">Batches for this Schedule:</label>
                                    <input class="form-control" type="number" name="maximum_batch" id="maximum_batch"
                                           placeholder="Batches" value="1" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label for="no_per_schedule">Candidate per Batch:</label>
                                    <input class="form-control" type="number" name="no_per_schedule"
                                           id="no_per_schedule" placeholder="Candidates per Batch" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label for="daily_start_time">Daily Start Time:</label>
                                    <input class="form-control" type="time" name="daily_start_time"
                                           id="daily_start_time" placeholder="Start Time" value="00:00" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3 col-xl-3">
                                <div class="form-group">
                                    <label for="daily_end_time">Daily End Time:</label>
                                    <input class="form-control" type="time" name="daily_end_time"
                                           id="daily_end_time" placeholder="End Time" value="23:59" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            {{--                            <a class="btn btn-warning text-light"--}}
                            {{--                               href="{{ route('admin.test.config.view',[$config_id]) }}"><i--}}
                            {{--                                    class="fa fa-arrow-left me-1"></i>Back</a>--}}
                            <input id="submit" class="btn btn-info text-light" type="submit" value="Save Changes"
                                   style="display: none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            Existing Schedules
        </div>
        <div class="card-body p-3">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Batches</th>
                    <th>No. Per Batch</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
                </thead>

                @php
                    $schedules = Scheduling::with('venue')->where(['test_config_id'=>$config_id])->get();
                @endphp
                <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{  Carbon::parse($schedule->date)->format('D jS M, Y') }}</td>
                        <td>{{ $schedule->venue->name }}</td>
                        <td>{{ $schedule->maximum_batch }}</td>
                        <td>{{ $schedule->no_per_schedule }}</td>
                        <td>{{  Carbon::parse($schedule->daily_start_time)->format('h:m a') }}</td>
                        <td>{{  Carbon::parse($schedule->daily_end_time)->format('h:m a') }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning text-light modify"
                               data-id="{{$schedule->id}}" data-date="{{$schedule->date}}"
                               data-venue="{{$schedule->venue->id}}" data-centre="{{$schedule->venue->centre->id}}"
                               data-batch="{{$schedule->maximum_batch}}" data-count="{{$schedule->no_per_schedule}}"
                               data-start="{{Carbon::parse($schedule->daily_start_time)->format('H:m')}}"
                               data-end="{{Carbon::parse($schedule->daily_end_time)->format('H:m')}}"
                               href="javascript:;">
                                Modify
                            </a>
                            <a class="btn btn-sm btn-danger text-light"
                               href="{{route('admin.test.config.schedules.delete',[$schedule->id])}}">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#exam-dates').on('change', function () {
                if ($(this).val() !== '0') $('#centre-div').show()
                else {
                    $('#submit').hide()
                    $('#venue-div').hide()
                    $('#centre-div').hide()
                    $('#batches-div').hide()
                }
            })

            $('#centre').on('change', function () {
                $.get('{{ route('admin.misc.venues',[':id']) }}'.replace(':id', $(this).val()), function (data) {
                    $('#venue-div').show()
                    let options = `<option value='0'>---</option>`
                    $.each(data, function (i, v) {
                        options += `<option value='${v.id}'>${v.name}</option>`
                    })
                    $('#venue').html(options)
                })
            })

            $('#venue').on('change', function () {
                if ($(this).val() !== '0') {
                    $('#submit').show()
                    $('#batches-div').show()

                    $.get('{{ route('admin.misc.batches.capacity',[':id']) }}'.replace(':id', $(this).val()),
                        function (venue) {
                            $('#no_per_schedule').val(venue.capacity)
                        }
                    )
                } else {
                    $('#submit').hide()
                    $('#batches-div').hide()
                }
            })

            $('.modify').on('click', function () {
                console.log($(this).data('start'))
                $('#schedule_id').val($(this).data('id'))
                $('#exam-dates').val($(this).data('date')).change()
                $('#centre').val($(this).data('centre')).change()
                $('#venue').val($(this).data('venue')).change()
                $('#maximum_batch').val($(this).data('batch'))
                $('#no_per_schedule').val($(this).data('count'))
                $('#daily_start_time').val($(this).data('start'))
                $('#daily_end_time').val($(this).data('end'))
            })
        })
    </script>
@endsection
