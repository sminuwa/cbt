@php use App\Models\Centre;use App\Models\ExamsDate;use App\Models\Faculty;use Carbon\Carbon; @endphp
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
    <form action="{{ route('admin.test.config.mappings.store') }}" method="post">
        @csrf
        <div class="row mt-3">
            <div class="col-8 col-lg-8 col-xl-8 col-md-12">
                <div class="card border-info">
                    <div class="card-header border-info">
                        Test Mapping
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="scheduling">Test Schedule:</label>
                                    <select class="form-control form-select" id="scheduling" name="scheduling_id"
                                            required>
                                        <option></option>
                                        @foreach($schedules as $schedule)
                                            <option value="{{$schedule->id}}">
                                                {{ Carbon::parse($schedule->date)->format('D, jS M, Y') }}
                                                {{Carbon::parse($schedule->daily_start_time)->format('h:m a')}}
                                                / {{ $schedule->centre }} / {{ $schedule->venue }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="faculty-mappings" class="row">

        </div>
    </form>
@endsection

@section('script')
    <script>
        $(function () {
            $('#scheduling').on('change', function () {
                if ($(this).val() === '') {
                    $('#faculty-mappings').html('')
                    return
                }
                $.get('{{ route('admin.misc.faculty.mappings',[':id']) }}'.replace(':id', $(this).val()), function (response) {
                     $('#faculty-mappings').html(response)
                })
            })
        })
    </script>
@endsection
