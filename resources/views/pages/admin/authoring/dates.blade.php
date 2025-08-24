@extends('layouts.app')

@section('content')
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between align-items-center">
                        <span>Test Dates</span>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="{{ route('admin.test.config.subjects', $config->id) }}" class="btn btn-xs btn-outline-primary" title="Test Papers">
                                    <i class="las la-book"></i> Papers
                                </a>
                                <a href="{{ route('admin.test.config.composition', $config->id) }}" class="btn btn-xs btn-outline-success" title="Test Composition">
                                    <i class="las la-layer-group"></i> Composition
                                </a>
                                <a href="{{ route('admin.test.config.schedules', $config->id) }}" class="btn btn-xs btn-outline-warning" title="Test Schedules">
                                    <i class="las la-calendar-alt"></i> Schedules
                                </a>
                                <a href="{{ route('admin.test.config.basics', $config->id) }}" class="btn btn-xs btn-outline-info" title="Test Config">
                                    <i class="las la-cog"></i> Config
                                </a>
                            </div>
                            <a href="{{ route('admin.test.config.index') }}" class="btn btn-info btn-xs text-light">
                                <i class="las la-arrow-left"></i> Panel
                            </a>
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="">
            <div class="text-center mt-4">
                <h5 class="text-muted">Manage Test Dates</h5>
                <h4 class="test-title">{{ $config->title }} - {{ $config->session }} - {{ $config->test_code->name ?? 'No Code' }} - {{ $config->test_type->name ?? 'No Type' }}</h4>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
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
            
            <div class="input-group flatpicker-calender py-4">
                <input name="date" class="form-control" id="test-date" type="date" placeholder="Pick date (eg. {{ date('Y-m-d') }})">
            </div>

            {{-- <input type="text" class="form-control" id="datepicker" style="display: none"> --}}
            <div id="dates">
                @if(count($dates))
                    <div class="doc-times ">
                        
                            @foreach($dates as $date)
                            
                                <div class="d-inline">
                                    <a href="javascript:void(0)" data-id="{{ $date->id }}" class="btn btn-primary  my-1 delete_schedule">
                                        {{ \Carbon\Carbon::parse($date->date)->format('D jS M, Y') }} <i class="fa fa-times text-light"></i>
                                    </a>
                                </div>
                            
                            @endforeach
                        
                    </div>
                @else
                    <div style="width:100%;height: 100%;display: flex;justify-content: center;align-items: center"
                         class="pt-4">
                        No date added
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            // $('#add-date').on('click', function () {
            //     $(".datepicker").datepicker()
            //     $('.datepicker').focus()
            // })

            flatpickr("#test-date", {
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                minDate: new Date()
            });

            $('#test-date').datepicker().on("change", function (e) {
                $.post('{{ route('admin.test.config.dates.store') }}', {
                    '_token': '{{ csrf_token() }}',
                    'test_config_id': '{{$config_id}}',
                    'date': e.target.value
                }, function (response) {
                    $('#dates').html(response)
                })
            })

            $(document).on('click', '.delete_schedule', function () {
                let id = $(this).data('id')
                $.get('{{ route('admin.test.config.dates.delete',[':id']) }}'.replace(':id', id), function (response) {
                    $('#dates').html(response)
                })
            })
        })
    </script>
@endsection


