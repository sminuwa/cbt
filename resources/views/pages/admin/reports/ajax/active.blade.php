@if(count($actives)==0)
    <h4 style="text-align: center">No active candidate taking this test</h4>
@else
    {{--    <div class="card border-info">--}}
    {{--        <div class="card-body" style="padding: 1px !important;">--}}
    {{--            <table class="table table-bordered">--}}
    {{--                <tbody>--}}
    {{--                <tr>--}}
    {{--                    <th>#</th>--}}
    {{--                    <th>Indexing</th>--}}
    {{--                    <th>Candidate</th>--}}
    {{--                    <th>IP Address</th>--}}
    {{--                    <th>Action</th>--}}
    {{--                </tr>--}}
    {{--                </tbody>--}}
    {{--                <tbody>--}}
    {{--                --}}
    {{--                    <tr>--}}
    {{--                        <td>{{$loop->iteration}}</td>--}}
    {{--                        <td>{{$active->indexing}}</td>--}}
    {{--                        <td>{{$active->name}}</td>--}}
    {{--                        <td>{{$active->address}}</td>--}}
    {{--                        <td></td>--}}
    {{--                    </tr>--}}
    {{--                @endforeach--}}
    {{--                </tbody>--}}
    {{--            </table>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="card card-table">
        <div class="card-body">
        <div class="table-responsive">
            <table class="datatable table table-hover table-center mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Indexing</th>
                        <th>Full name</th>
                        <th>IP Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actives as $active)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>                        
                                <a href="patient-profile.html" class="avatar avatar-sm me-2">
                                    <img class="avatar-img rounded-circle" src="{{asset('assets/img/patients/patient2.jpg')}}" alt="{{$active->indexing}} - {{$active->name}}">
                                </a>
                            </td>
                            <td>{{$active->indexing}}</td>
                            <td>{{$active->name}}</td>
                            <td>{{$active->address}}</td>
                            <td>
                                <a href="javascript:;" class="btn btn-sm btn-outline-danger">End Exam</a>
                                <a href="javascript:;" class="btn btn-sm btn-outline-info">Restore</a>
                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">Adjust Time</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- @foreach($actives as $active)
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="card border-info widget-profile pat-widget-profile">
                    <div class="card-body">
                        <div class="pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="#" class="booking-doc-img">
                                    <img src="{{asset('assets/img/patients/patient2.jpg')}}" alt="User Image">
                                </a>
                                <div class="profile-det-info">
                                    <h4>{{$active->name}}</h4>
                                    <div class="patient-details">
                                        <h5><b>{{$active->indexing}}</b></h5>
                                        <h5 class="mb-0"><i class="fas fa-map-pin"></i>{{$active->address}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>
    </div>
@endif
