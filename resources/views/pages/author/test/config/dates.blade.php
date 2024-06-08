@extends('layouts.app')

@section('content')
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Test Dates</span>
                        <a id="add-date" class="btn btn-info text-light"><i class="fa fa-add me-1"></i>Add New</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="min-height: 100px;">
            <input type="text" class="form-control" id="datepicker" style="display: none">
            <div id="dates">
                @if(count($dates))
                    <div class="doc-times pt-3">
                        @foreach($dates as $date)
                            <div class="doc-slot-list" style="background-color: #1d75b3;border: 1px solid #1d75b3;">
                                {{ \Carbon\Carbon::parse($date->date)->format('D jS M, Y') }}
                                <a href="javascript:void(0)" data-id="{{ $date->id }}" class="delete_schedule">
                                    <i class="fa fa-times text-light"></i>
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
            $('#add-date').on('click', function () {
                $("#datepicker").datepicker()
                $('#datepicker').focus()
            })

            $('#datepicker').datepicker().on("input change", function (e) {
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


