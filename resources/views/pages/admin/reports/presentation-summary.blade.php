@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
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
                                    <span>Presentation Summary</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" style="padding: 1px !important;"></div>
                </div>
                <form id="preview-form" method="post">
                    @csrf
                    <div class="row pb-3 pt-2">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="test_config">Test:</label>
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

                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="test_type_id">Candidate(s):</label>
                                {{--                                <div style="max-height:300px; overflow: auto;">--}}

                                {{--                                </div>--}}
                                <select multiple class="form-control form-select" name="candidates[]" id="candidates"
                                        required>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2 col-xl-2">
                            <input type="submit" class="btn btn-info text-light mt-4" value="Generate"/>
                        </div>
                    </div>
                </form>
                <div id="presentation-div"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Datatables JS -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(function () {
            $('#test_config').on('change', function () {
                const id = $(this).val()
                if (id !== '')
                    $.get('{{route('admin.misc.test.candidates',[':c'])}}'.replace(':c', id), function (response) {
                        $('#candidates').html(response)
                    })
                else $('#candidates').html('')
            })

            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('admin.reports.summary.generate.presentation') }}', $(this).serialize(), function (response) {
                    // console.log(response)
                    $('#presentation-div').html(response)
                })
            })
        })
    </script>
@endsection
