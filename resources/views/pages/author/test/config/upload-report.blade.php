@extends('layouts.app')
@section('css')
    <style>
        .list-group.ordered-list {
            counter-reset: list-counter;
        }

        .list-group.ordered-list .list-group-item {
            position: relative;
            padding-left: 25px;
        }

        .list-group.ordered-list .list-group-item::before {
            content: counter(list-counter, circle) ".  ";
            counter-increment: list-counter;
            position: absolute;
            left: 0em;
            top: 0.5em;
        }
    </style>
@endsection
@section('content')
    <div class="card border-info">
        <div class="card-header border-info">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Upload Candidate Report</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span class="text-info">Successfully Scheduled: </span><strong>{{$success}}</strong>
                </div>
                <div class="col-4">
                    <span class="text-warning">Already Scheduled: </span><strong>{{$scheduled}}</strong>
                </div>
                <div class="col-4">
                    <span class="text-danger">Missing Records: </span><strong>{{count($missing)}}</strong>
                </div>
            </div>
        </div>
    </div>
    @if(count($missing))
        <div class="card border-info">
            <div class="card-header border-info">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-between">
                            <span>Missing Records</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ol class="list-group list-group-flush ordered-list">
                    @foreach($missing as $number)
                        <li class="list-group-item">{{ $number }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        $(function () {
        })
    </script>
@endsection
