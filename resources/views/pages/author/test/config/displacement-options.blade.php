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
        <div class="card-header border-info">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Caution!</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p> Your operation is about to displace <strong>{{$candidates}}</strong> candidate(s)</p>
            <h4 class="pt-3">Actions:</h4>
            <a class="btn btn-sm btn-outline-secondary" href="{{url()->previous()}}">Cancel Operation</a>
            <br>
            <a class="btn btn-sm btn-outline-danger mt-3"
               href="{{route('admin.test.config.schedules.remove.delete',[$scheduling->id])}}">
                Remove affected Candidate(s) & Delete the Schedule
            </a>
            <br>
            <a class="btn btn-sm btn-outline-info mt-3 reschedule" href="javascript:;" data-id="{{$scheduling->id}}">
                Reschedule affected Candidate(s) & Delete the Schedule
            </a>
        </div>
    </div>

    <div id="schedules-div" style="display: none">
        <div class="card border-info">
            <div class="card-header border-info">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-between">
                            <span>Select a schedule for the {{$candidates}} candidate(s)</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div id="others" class="card-body p-0">

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            let selection = 0
            $('.reschedule').on('click', function () {
                $.get('{{route('admin.test.config.schedules.others',[':id',$candidates])}}'.replace(':id', $(this).data('id')),
                    function (response) {
                        $('#schedules-div').show()
                        $('#others').html(response)
                    }
                )
            })

            $(document).on('click', '.selection', function () {
                let id = $(this).val()
                $(document).find('#reschedule').show()
            })

            $(document).on('click', '.selection', function () {
                selection = $(this).val()
                $(document).find('#reschedule').show()
            })

            $(document).on('click', '#reschedule', function () {
               //   Reschedule cands
            })
        })
    </script>
@endsection
