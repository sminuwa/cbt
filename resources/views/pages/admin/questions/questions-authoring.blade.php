@extends('layouts.app')

@section('content')

    <div class="row">
        <x-head.tinymce-config/>

        <div class="col-md-12 col-lg-12 col-xl-12">

            <div class="row patient-graph-col">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Question Authoring</h4>
                        </div>
                        <div class="card-body pt-2 pb-2 mt-1 mb-1">
                            <div class="row">
                                <form method="post" action="{{ route('admin.questions.authoring.post') }}">
                                    @csrf
                                    <div class="row pb-3 pt-2">
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label for="subject_id">Subject:</label>
                                                <select class="form-control form-select" name="subject_id"
                                                        id="subject_id" required>
                                                    <option value="">Select Subject</option>
                                                    @foreach(\App\Models\Subject::all() as $subject)
                                                        <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label for="topic_id">Topic:</label>
                                                <select class="form-control form-select" name="topic_id" id="topic_id"
                                                        required>
                                                    <option value="">Select Topic</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <textarea id="question-editor" name="content"></textarea>
                                    <input class="btn btn-sm btn-info mt-3 text-light" type="submit" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('#subject_id').on('change', function () {
                let id = $(this).val();
                $.get('{{ route('admin.questions.authoring.topics',[':id']) }}'.replace(':id', id), function (data) {
                    $('#topic_id').html(data)
                })
            })
        })
    </script>
@endsection
