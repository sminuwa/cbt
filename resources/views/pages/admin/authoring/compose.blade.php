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
                                <th>Number of Questions</th>
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
                                        <a class="btn btn-sm btn-outline-info compose"
                                           href="{{route('admin.test.config.composition.compose.questions',[$section->id])}}">
                                            Compose
                                        </a>
                                        <a class="btn btn-sm btn-outline-warning edit" href="javascript:;"
                                           data-id="{{ $section->id }}"
                                           data-title="{{$section->title}}"
                                           data-mark="{{$section->mark_per_question}}"
                                           data-count="{{$section->num_to_answer}}"
                                           data-easy="{{$section->num_of_easy}}"
                                           data-mod="{{$section->num_of_moderate}}"
                                           data-diff="{{$section->num_of_difficult}}"
                                           data-inst="{{$section->instruction}}">
                                            Modify
                                        </a>
                                        <a class="btn btn-sm btn-outline-danger remove"
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
                            No paper registered
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card border-info">
        {{--        <x-head.tinymce-config/>--}}
        <div class="card-header border-info">
            <h4 class="card-title d-flex justify-content-between">
                <span>New Section</span>
            </h4>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('admin.test.config.composition.compose.store') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="section_id">
                <input type="hidden" name="test_subject_id" value="{{ $testSubject->id }}">
                <div class="row mt-1">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group">
                            <textarea id="instruction" name="instruction" placeholder="Instructions (if any)">
                            </textarea>
                        </div>
                    </div>
                </div>
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
                            <label for="mark">Mark Per Question:</label>
                            <input class="form-control" type="number" step=".01" name="mark_per_question" id="mark"
                                   required>
                        </div>
                    </div>
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="count">Number of Questions:</label>
                            <input class="form-control" type="number" name="num_to_answer" id="count" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="easy">Simple Questions Count:</label>
                            <input class="form-control" type="number" name="num_of_easy" id="easy" required>
                        </div>
                    </div>
                    <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group">
                            <label for="moderate">Moderate Questions Count:</label>
                            <input class="form-control" type="number" name="num_of_moderate" id="moderate" required>
                        </div>
                    </div>
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
                    <input class="btn btn-info text-light" id="submit" type="submit" value="Add Section">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            height: 200,
            license_key: 'gpl',
            selector: 'textarea#instruction', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
    <script>
        $(function () {
            $('.edit').on('click', function () {
                $('#section_id').val($(this).data('id'))
                $('#title').val($(this).data('title'))
                $('#mark').val($(this).data('mark'))
                $('#count').val($(this).data('count'))
                $('#easy').val($(this).data('easy'))
                $('#moderate').val($(this).data('mod'))
                $('#difficult').val($(this).data('diff'))
                $('#submit').val('Save Section')
                tinymce.activeEditor.setContent($(this).data('inst'));
            })

            $(document).on('click', '.composition', function () {
                let id = $(this).data('id')
                $.get('{{ route('admin.test.config.subject.remove',[':id']) }}'.replace(':id', id), function () {
                })
            })

            $('.remove').on('click', function () {
                const sectionId = $(this).data('id');
                const sectionTitle = $(this).closest('tr').find('td:nth-child(2)').text();
                const buttonElement = this;
                
                Swal.fire({
                    title: 'Delete Section?',
                    html: `Are you sure you want to delete the section <strong>"${sectionTitle}"</strong>?<br><br>
                           <div class="text-warning">
                               <i class="las la-exclamation-triangle"></i> 
                               This will also delete all questions associated with this section.
                           </div><br>
                           <strong>This action cannot be undone.</strong>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete Section!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete the section and related questions.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const deleteUrl = '{{ route('admin.test.config.composition.section.delete', ':id') }}'.replace(':id', sectionId);
                        
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Show success message
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                    
                                    // Remove the table row
                                    $(buttonElement).closest('tr').fadeOut(300, function() {
                                        $(this).remove();
                                        // Check if table is empty and show message
                                        if ($('tbody tr:visible').length === 0) {
                                            $('tbody').html('<tr><td colspan="6" class="text-center">No sections available</td></tr>');
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                const errorMessage = xhr.responseJSON?.message || 'An error occurred while deleting the section';
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            })
        })
    </script>
@endsection
