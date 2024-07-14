@extends('layouts.app')

@section('content')
    <div id="container" class="container">
        <div class="page-header">
            <h1>Candidate Types</h1>
            <br/>
            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#myModal">Add New Candidate Type</a>
            <br/>
        </div>

        <table class="datatable table-bordered table-striped">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($candidateTypes as $type)
                <tr>
                    <td>{{ $loop->index+1}}</td>
                    <td>{{ $type->name }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm ml-30 edit"
                           href="#" data-toggle="modal"
                           data-target="#myModal"
                           data-id="{{$type->id}}"
                           data-name="{{$type->name}}"
                        >
                            Edit
                            <span class="icon icon_pencil-edit"></span>
                        </a>
                        <button class="btn btn-sm btn-danger delete" data-id="{{ $type->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade custom-modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-left" id="myModalLabel">Add new
                        Rank
                        <div class="double-line-bottom-theme-colored-2"></div>
                    </h4>
                </div>
                <form class="form" action="{{route('toolbox.candidate-types.create')}}" method="POST" style="width: 100%; margin-top: 3vh; ">
                    @csrf
                    <div class="modal-body" style="min-height:180px;">
                        <input type="hidden" id="type_id" value="0"
                               name="type_id"/>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="type">Name:</label>
                                <input type="text" id="type"
                                       class="form-control {{ $errors->has('exam-type')?'is-invalid':'is-valid' }}"
                                       name="type"
                                       value=""
                                       placeholder="Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" id="addbtn"
                                    class="btn btn-flat btn-success text-right"><span
                                    class="icon icon-save"> Save </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script>
    $(document).ready(function () {
        $(document).on('click', '.add', function () {
            $(".modal-body #type").val('');
        });

        $(document).on('click', '.edit', function () {
            const id = $(this).data('id');
            const type = $(this).data('type');

            $(".modal-body #id").val(id);
            $(".modal-body #type").val(type);
        });
    });
</script>
