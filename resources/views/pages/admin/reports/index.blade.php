@extends('layouts.app')

@section('content')
    <div class="card border-info">
        <div class="card-header border-info">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Reports</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-4">
            {{--            <a style="width: 18%" class="btn btn-outline-info btn-sm" href="{{route('admin.reports.test.index')}}">--}}
            {{--                Test Reports--}}
            {{--            </a>--}}
            <a style="width: 24%" class="btn btn-outline-info btn-sm" href="{{route('admin.reports.summary.reports')}}">
                Report Summary
            </a>
            <a style="width: 24%" class="btn btn-outline-info btn-sm"
               href="{{route('admin.reports.summary.question')}}">
                Question Summary
            </a>
            <a style="width: 24%" class="btn btn-outline-info btn-sm"
               href="{{route('admin.reports.summary.presentation')}}">
                Presentation Summary
            </a>
            <a style="width: 24%" class="btn btn-outline-info btn-sm" href="{{route('admin.reports.active.index')}}">
                Active Candidates
            </a>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
        })
    </script>
@endsection
