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
                        <span>Test Composition</span>
                        <a href="{{ route('admin.test.config.index') }}" class="btn btn-info btn-xs text-light"><i class="las la-arrow-left"></i>Back</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0 text-center">
            <h5 class="text-muted">Manage Test Composition</h5>
            <h4 class="test-title">{{ $config->title }} - {{ $config->session }} - {{ $config->test_code->name ?? 'No Code' }} - {{ $config->test_type->name ?? 'No Type' }}</h4>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
                        @if($config->paper)
                        <div class="test-info-item">
                            <i class="las la-file-alt text-primary me-2"></i>
                            <span><strong>Paper:</strong> {{$config->paper}}</span>
                        </div>
                        @endif
                        @if($config->code)
                        <div class="test-info-item">
                            <i class="las la-code text-primary me-2"></i>
                            <span><strong>Code:</strong> {{$config->code}}</span>
                        </div>
                        @endif
                        @if($config->year)
                        <div class="test-info-item">
                            <i class="las la-calendar text-primary me-2"></i>
                            <span><strong>Year:</strong> {{$config->year}}</span>
                        </div>
                        @endif
                        @if($config->exam_type)
                        <div class="test-info-item">
                            <i class="las la-graduation-cap text-primary me-2"></i>
                            <span><strong>Type:</strong> {{$config->exam_type}}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            Available Test Papers
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-12">
                    @if(count($subjects))
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10%">#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th style="text-align: center">Sections</th>
                                <th style="text-align: center">Questions</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $registered)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $registered->subject->subject_code }}</td>
                                    <td>{{ $registered->subject->name }}</td>
                                    <td style="text-align: center">{{ count($registered->test_sections) }}</td>
                                    <td style="text-align: center">{{ $registered->questions() }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-info"
                                           data-id="{{ $registered->id }}"
                                           href="{{ route('admin.test.config.composition.compose',[$registered->id]) }}">
                                            Compose
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="width:100%;height: 100px;display: flex;justify-content: center;align-items: center">
                            No paper registered
                        </div>
                    @endif
                </div>
            </div>
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
