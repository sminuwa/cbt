@php use App\Models\TestCode;use App\Models\TestType; @endphp
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
        <div class="row patient-graph-col">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="row">
                            <div>
                                <h4 class="card-title d-flex justify-content-between">
                                    <span>Question Summary</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <form id="preview-form" method="post">
                            @csrf
                            <div class="row pt-2">
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label for="semester">Test:</label>
                                        <select class="form-control form-select" name="test_config_id" id="test_config"
                                                required>
                                            <option value="">Select Test</option>
                                            @foreach($configs as $config)
                                                <option value="{{$config->id}}">
                                                    {{ $config->session }} - {{ $config->test_code->name}}
                                                    - {{ $config->test_type->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label for="test_type_id">Test Subject:</label>
                                        <select class="form-control form-select" name="test_subject_id"
                                                id="test_subject"
                                                required>
                                            <option value="">Select Subject</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <input type="submit" class="btn btn-info text-light mt-4" value="Generate"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="questions-div"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#test_config').on('change', function () {
                const test = $(this).val()
                if (test !== '') {
                    $.get('{{route('admin.misc.test.subjects',[':c'])}}'.replace(':c', test), function (response) {
                        // console.log(response)
                        $('#test_subject').html(response)
                    })
                }
            })

            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('admin.reports.summary.generate.question') }}', $(this).serialize(), function (response) {
                    // console.log(response)
                    $('#questions-div').html(response)
                })
            })

            $(document).on('click', '.full-question', function () {
                let options = $(document).find('#options-' + $(this).data('id'))
                if (options.is(':visible'))
                    options.hide()
                else
                    options.show()
            })
        })
    </script>
@endsection
