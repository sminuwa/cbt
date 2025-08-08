@php use App\Models\Subject; @endphp
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/datatables.min.css')}}">
@endsection

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
    <div class="row">
        <div class="row patient-graph-col">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <h4>Move Questions</h4>
                    </div>
                    <div class="card-body">
                        <form id="preview-form" method="post">
                            @csrf
                            <div class="row pb-3 pt-2">
                                <div class="col-12 col-md-6 col-lg-5 col-xl-5">
                                    <div class="form-group">
                                        <label for="subject_id">Paper:</label>
                                        <select class="form-control form-select" name="subject_id" id="subject_id"
                                                required>
                                            <option value="">Select Paper</option>
                                            @foreach(Subject::all() as $subject)
                                                <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5 col-xl-5">
                                    <div class="form-group">
                                        <label for="topic_id">Subject:</label>
                                        <select class="form-control form-select" name="topic_id" id="topic_id"
                                                required>
                                            <option value="">Select Subject</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-2 col-xl-2">
                                    <input type="submit" class="btn btn-info text-light mt-4" value="Load Questions"/>
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
    <!-- Datatables JS -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <script>
        $(function () {
            $('#subject_id').on('change', function () {
                let id = $(this).val();
                fetchTopics(id, $('#topic_id'))
            })

            $(document).on('click', '#subject_to_id', function () {
                let id = $(this).val();
                fetchTopics(id, $('#topic_to_id'))
            })

            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('admin.authoring.load.questions') }}', $(this).serialize(), function (response) {
                    $('#questions-div').html(response)
                    $('#questions').DataTable()
                })
            })

            $(document).on('click', '#check-all', function () {
                let checked = $(this).is(':checked')
                $('.selection').prop('checked', checked)
            })

            function fetchTopics(id, target) {
                $.get('{{ route('admin.authoring.topics',[':id']) }}'.replace(':id', id), function (data) {
                    target.html(data)
                })
            }
        })
    </script>
@endsection
