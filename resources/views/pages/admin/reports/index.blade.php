@php
    use Carbon\Carbon; @endphp
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
            <a style="width: 18%" class="btn btn-outline-info btn-sm" href="">Test Reports</a>
            <a style="width: 18%" class="btn btn-outline-info btn-sm" href="">Report Summary</a>
            <a style="width: 20%" class="btn btn-outline-info btn-sm" href="">Question Summary</a>
            <a style="width: 20%" class="btn btn-outline-info btn-sm" href="">Presentation Summary</a>
            <a style="width: 20%" class="btn btn-outline-info btn-sm" href="">Active Candidates</a>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
        })
    </script>
@endsection
