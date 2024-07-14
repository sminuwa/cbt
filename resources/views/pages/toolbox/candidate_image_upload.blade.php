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
        <div class="card border-info">
            <div class="card-header border-info">
                <div class="row">
                    <div>
                        <h4 class="card-title d-flex justify-content-between">
                            <span>Candidate Image Upload</span>
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="alert alert-warning">
            <b style="color:#00d9ff;">NOTE:</b> Supported image format: .jpg
        </div>
        <br>
        <div>
            <form action="{{route('toolbox.candidate_image_upload.upload.image.data')}}" method="post" enctype="multipart/form-data">
                @csrf
                <table>
                    <tr>
                        <td><label for="file">Select Photo (one or multiple):</label></td>
                        <td><input type="file" name="files[]" id="file" multiple accept=".jpg" required class="form-control"/></td>
                    </tr>
                    <tr>
                        <td align="center"><input type="submit" value="Upload Image(s)" class="btn btn-info" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

@endsection
