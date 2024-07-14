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
            content: counter(list-counter, upper-alpha) ".  ";
            counter-increment: list-counter;
            position: absolute;
            left: 0em;
            top: 0.5em;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <x-head.tinymce-config/>
        <div class="row patient-graph-col">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header">
                        <div class="row">
                            <div>
                                <h4 class="card-title d-flex justify-content-between">
                                    <span>Test Reports</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" style="padding: 1px !important;"></div>
                </div>
                <form id="report-form" method="post">
                    @csrf
                    <div class="row pb-3 pt-2">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="year">Date:</label>
                                <input id="year" class="form-control" type="date" name="year" placeholder="Year of Exam"
                                       value="12/05/2001" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <input type="submit" class="btn btn-info text-light mt-4" value="Generate"/>
                        </div>
                    </div>
                </form>
                <div id="report-preview-div"></div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('#report-form').on('submit', function (e) {
                e.preventDefault()
                {{--$.post('{{ route('admin.reports.daily.generate') }}', $(this).serialize(), function (response) {--}}
                {{--    console.log(response)--}}
                {{--    // $('#report-preview-div').html(response)--}}
                {{--})--}}
            })
        })
    </script>
@endsection
