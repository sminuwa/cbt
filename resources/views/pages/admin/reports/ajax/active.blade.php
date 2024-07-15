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

    <div class="row row-grid">
        @foreach($actives as $active)
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
        @endforeach
    </div>
@endif
