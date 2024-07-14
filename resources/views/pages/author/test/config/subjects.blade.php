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
                        <span>Test Papers</span>
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
                    Add Subject
                </div>
                <div class="card-body">
                    <div class="profile-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="subjects" class="doc-times pt-3">
                                    {{--                                        <div class="form-check-inline visits me-0">--}}
                                    {{--                                            <label class="visit-btns">--}}
                                    {{--                                                <input type="checkbox" class="form-check-input subject" value="18">--}}
                                    {{--                                                <span class="visit-rsn" data-bs-toggle="tooltip"--}}
                                    {{--                                                      title="{{ $subject->subject_code }}">--}}
                                    {{--                                                    {{ $subject->subject_code }} - {{ $subject->name   }}--}}
                                    {{--                                                </span>--}}
                                    {{--                                            </label>--}}
                                    {{--                                        </div>--}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            Registered Test Papers
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div id="registered-subjects" class="col-12">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function subjects() {
            $.get('{{ route('admin.test.config.subjects.ajax',[$config_id]) }}', function (response) {
                $('#subjects').html(response)
            })
        }

        function registered() {
            $.get('{{ route('admin.test.config.registered.subjects',[$config_id]) }}', function (response) {
                $('#registered-subjects').html(response)
            })
        }

        $(function () {
            subjects()
            registered()

            $(document).on('click', '.delete_schedule', function () {
                let id = $(this).data('id')
                $.post('{{ route('admin.test.config.subject.register') }}', {
                    'subject_id': id,
                    '_token': '{{ csrf_token() }}',
                    'test_config_id': {{ $config_id }}
                }, function () {
                    subjects()
                    registered()
                })
            })

            $(document).on('click', '.remove', function () {
                let id = $(this).data('id')
                $.get('{{ route('admin.test.config.subject.remove',[':id']) }}'.replace(':id', id), function () {
                    subjects()
                    registered()
                })
            })
        })
    </script>
@endsection
