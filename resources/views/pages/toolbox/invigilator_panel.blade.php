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
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/datatables.min.css-')}}">
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-between">
                            <span>Candidate(s)</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="report-form" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group">
                                <label class="col-form-label"></label>
                                <select id="test_id" name="test_config_id" class="form-control"
                                        type="text" required>
                                    <option value="">-- Select Exam --</option>
                                    @foreach($testConfigs as $exam)
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

@endsection

@section('script')
	{{-- <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js-')}}"></script>
    <script src="{{asset('assets/plugins/datatables/datatables.min.js-')}}"></script> --}}
    <script>
        $(function () {
           
            $('#test_id').on('change', function () {
                $.post('{{ route('admin.reports.active.generate') }}', $('#report-form').serialize(), function (response) {
                    $('#report-preview-div').html(response)
                }).done(function(response){
                    console.log(response)
                    $('.display').DataTable({
                        responsive:true,
                        dom: "Bfrtip",
                        buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                    });
                    
                })
            })

            
        })
    </script>
@endsection
