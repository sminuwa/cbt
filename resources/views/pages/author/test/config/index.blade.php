@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body pt-0">

            <!-- Tab Menu -->
            <nav class="user-tabs mb-4">
                <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" href="#pat_appointments" data-bs-toggle="tab">Test Configurations</a>
                    </li>
                </ul>
            </nav>
            <!-- /Tab Menu -->

            <!-- Tab Content -->
            <div class="tab-content pt-0">

                <!-- Appointment Tab -->
                <div id="pat_appointments" class="tab-pane fade show active">
                    <div class="card card-table mb-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Appt Date</th>
                                        <th>Booking Date</th>
                                        <th>Amount</th>
                                        <th>Follow Up</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-01.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Ruby Perrin <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>14 Nov 2023 <span class="d-block text-info">10.00 AM</span></td>
                                        <td>12 Nov 2023</td>
                                        <td>$160</td>
                                        <td>16 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Darren Elder <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>12 Nov 2023 <span class="d-block text-info">8.00 PM</span></td>
                                        <td>12 Nov 2023</td>
                                        <td>$250</td>
                                        <td>14 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-03.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Deborah Angel <span>Cardiology</span></a>
                                            </h2>
                                        </td>
                                        <td>11 Nov 2023 <span class="d-block text-info">11.00 AM</span></td>
                                        <td>10 Nov 2023</td>
                                        <td>$400</td>
                                        <td>13 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-danger-light">Cancelled</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-04.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Sofia Brient <span>Urology</span></a>
                                            </h2>
                                        </td>
                                        <td>10 Nov 2023 <span class="d-block text-info">3.00 PM</span></td>
                                        <td>10 Nov 2023</td>
                                        <td>$350</td>
                                        <td>12 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-warning-light">Pending</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-05.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Marvin Campbell <span>Ophthalmology</span></a>
                                            </h2>
                                        </td>
                                        <td>9 Nov 2023 <span class="d-block text-info">7.00 PM</span></td>
                                        <td>8 Nov 2023</td>
                                        <td>$75</td>
                                        <td>11 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-06.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Katharine Berthold <span>Orthopaedics</span></a>
                                            </h2>
                                        </td>
                                        <td>8 Nov 2023 <span class="d-block text-info">9.00 AM</span></td>
                                        <td>6 Nov 2023</td>
                                        <td>$175</td>
                                        <td>10 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-danger-light">Cancelled</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-07.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Linda Tobin <span>Neurology</span></a>
                                            </h2>
                                        </td>
                                        <td>8 Nov 2023 <span class="d-block text-info">6.00 PM</span></td>
                                        <td>6 Nov 2023</td>
                                        <td>$450</td>
                                        <td>10 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-08.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Paul Richard <span>Dermatology</span></a>
                                            </h2>
                                        </td>
                                        <td>7 Nov 2023 <span class="d-block text-info">9.00 PM</span></td>
                                        <td>7 Nov 2023</td>
                                        <td>$275</td>
                                        <td>9 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-09.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. John Gibbs <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>6 Nov 2023 <span class="d-block text-info">8.00 PM</span></td>
                                        <td>4 Nov 2023</td>
                                        <td>$600</td>
                                        <td>8 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="/assets/img/doctors/doctor-thumb-10.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Olga Barlow  <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>5 Nov 2023 <span class="d-block text-info">5.00 PM</span></td>
                                        <td>1 Nov 2023</td>
                                        <td>$100</td>
                                        <td>7 Nov 2023</td>
                                        <td><span class="badge rounded-pill bg-success-light">Confirm</span></td>
                                        <td>
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Appointment Tab -->

            </div>
            <!-- Tab Content -->

        </div>
    </div>
@endsection
