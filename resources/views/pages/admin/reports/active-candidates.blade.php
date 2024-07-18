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
                    <div class="card-header border-info">
                        <div class="row">
                            <div>
                                <h4 class="card-title d-flex justify-content-between">
                                    <span>Active Candidate(s)</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <form id="report-form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="form-group">
                                        <label class="col-form-label"></label>
                                        <select id="test_id" name="test_config_id" class="form-control"
                                                type="text" required>
                                            <option value="">-- Select Exam --</option>
                                            @foreach($exams as $exam)
                                                <option value="{{ $exam->id }}">{{ $exam->code }} - {{ $exam->type }}
                                                    - {{ $exam->session }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="report-preview-div"></div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('#test_id').on('change', function () {
                $.post('{{ route('admin.reports.active.generate') }}', $('#report-form').serialize(), function (response) {
                    // console.log(response)
                    $('#report-preview-div').html(response)
                })
            })
        })
    </script>
@endsection
