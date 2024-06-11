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
                        <span>Test Composition</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            Available Sections(s) in <strong>{{ $testSubject->subject->subject_code }}</strong>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-12">
                    @if(count($sections))
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10%">#</th>
                                <th>Section Title</th>
                                <th>Mark Per Quest</th>
                                <th>Questions Count</th>
                                <th>Total Marks</th>
                                <th style="width: 30%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sections as $section)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $section->title }}</td>
                                    <td>{{ $section->mark_per_question }}</td>
                                    <td>{{ $section->num_to_answer }}</td>
                                    <td>{{ $section->num_to_answer * $section->mark_per_question }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-info composition"
                                           data-id="{{ $section->id }}" href="javascript:;">
                                            Compose
                                        </a>
                                        <a class="btn btn-sm btn-outline-warning composition"
                                           data-id="{{ $section->id }}" href="javascript:;">
                                            Modify
                                        </a>
                                        <a class="btn btn-sm btn-outline-danger composition"
                                           data-id="{{ $section->id }}" href="javascript:;">
                                            Remove
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="width:100%;height: 50px;display: flex;justify-content: center;align-items: center">
                            No subject registered
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            New Section
        </div>
        <div class="card-body p-3">
            <form action="{{ route('admin.test.config.composition.compose.store') }}" method="post">
                @csrf
                <input type="hidden" name="test_subject_id" value="{{ $testSubject->id }}">
                <div class="row mt-3">
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="title">Section Title:</label>
                            <input class="form-control" type="text" name="title" id="title" placeholder="e.g SECTION A"
                                   required>
                        </div>
                    </div>
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="instruction">Instructions (if any):</label>
                            <input class="form-control" type="text" name="instruction" id="instruction">
                        </div>
                    </div>
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="mark">Mark Per Question:</label>
                            <input class="form-control" type="number" name="mark_per_question" id="mark" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="num_to_answer">Questions Count:</label>
                            <input class="form-control" type="number" name="num_to_answer" id="num_to_answer" required>
                        </div>
                    </div>
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="num_of_easy">Easy Questions Count:</label>
                            <input class="form-control" type="number" name="num_of_easy" id="num_of_easy" required>
                        </div>
                    </div>
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="moderate">Moderate Questions Count:</label>
                            <input class="form-control" type="number" name="num_of_moderate" id="moderate" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="difficult">Difficult Questions Count:</label>
                            <input class="form-control" type="number" name="num_of_difficult" id="difficult" required>
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    {{--                    <a class="btn btn-warning text-light"--}}
                    {{--                       href="{{ route('admin.test.config.composition',[$testSubject->test_config_id]) }}"><i--}}
                    {{--                            class="fa fa-arrow-left me-1"></i>Back</a>--}}
                    <input class="btn btn-info text-light" type="submit" value="Add Section">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $(document).on('click', '.composition', function () {
                let id = $(this).data('id')
                $.get('{{ route('admin.test.config.subject.remove',[':id']) }}'.replace(':id', id), function () {
                })
            })
        })
    </script>
@endsection
