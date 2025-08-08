@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-between">
                            <span>Candidate Image Upload</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table mb-4">
                                <tbody>
                                    <tr>
                                        <th>Candidate without pictures: </th>
                                        <td><h2>{{ number_format($candidate_pictures['total']) }}</h2></td>
                                    </tr>
                                 
                                </tbody>
                            </table>
                            <form class="generate-candidate-picture" action="{{ route('generate-candidate-picture') }}" method="post">
                                @csrf
                                <input type="hidden" name="candidate_ids" value="">
                                <button type="submit" class="btn btn-primary generate-pictures">Generate pictures</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{route('toolbox.candidate_image_upload.upload.image.data')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="alert alert-warning">
                                    <b style="color:#00d9ff;">NOTE:</b> Supported image format: .jpg
                                </div>
                                <div class="form-group mb-4">
                                    <label for="file">Select Photo (one or multiple):</label>
                                    <input type="file" name="files[]" id="file" multiple accept=".jpg" required class="form-control"/>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="submit" value="Upload Image(s)" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

       
    </div>

@endsection

@section('script')
    <script>
        $('body').on('submit','.generate-candidate-picture', function(e){
            e.preventDefault();
            let url = $(this).attr('action');
            let data = $(this).serialize();
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                success: function(response){
                    console.log(response);
                }
            })
        })
    </script>
@endsection
