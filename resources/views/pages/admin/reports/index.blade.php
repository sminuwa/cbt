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
            <a class="btn btn-info btn-sm text-white" href="">Daily Reports</a>
            <a class="btn btn-info btn-sm text-white" href="">Report By Test Code</a>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
        })
    </script>
@endsection
