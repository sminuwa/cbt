@extends('layouts.app')

@section('content')

    <div class="row">
        <x-head.tinymce-config/>
        <div class="row patient-graph-col">
            <div class="col-12">
                <h4 class="mb-5 mt-5">
                </h4>
                <div class="card border-info">
                    <div class="card-header">
                        <h4 class="card-title">Questions Authoring Successful!</h4>
                    </div>
                    <div class="card-body pt-2 pb-2  mt-1 mb-1">
                        <div class="row">
                            <div class="row pb-3 pt-2">
                                <p>The process of questions authoring is now completed successfully. Click the
                                    bottom below to go back<br>

                                    <a href="{{route('admin.questions.authoring.index')}}"
                                       class="btn btn-sm btn-info mt-5 text-light">Go Back</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
