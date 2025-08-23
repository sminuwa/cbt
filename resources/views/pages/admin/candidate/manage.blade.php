@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}")
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="card-title">
                        <span>Manage Candidates</span>
                    </h4>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="las la-filter"></i> Filter
                    </button>
                    <button type="button" id="pull-candidates-btn" class="btn btn-success btn-sm">
                        <i class="las la-download"></i> Pull Candidates
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Candidates Table -->
            <div class="table-responsive">
                <table id="candidates-table" class="display table table-striped table-hover nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Passport</th>
                            <th>Actions</th>
                            <th>Exam No</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Test Code</th>
                            <th>Exam Year</th>
                            <th>Attempt</th>
                            <th>Status</th>
                            <th>Registration ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via DataTables Ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Candidates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="exam_year_filter">Exam Year</label>
                                <select id="exam_year_filter" class="form-control">
                                    <option value="">All Years</option>
                                    @foreach($examYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="programme_id_filter">Cadre/Programme</label>
                                <select id="programme_id_filter" class="form-control">
                                    <option value="">All Cadres</option>
                                    @foreach($testCodes as $testCode)
                                        <option value="{{ $testCode->id }}">{{ $testCode->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="clear_filters">Clear Filters</button>
                    <button type="button" class="btn btn-primary" id="apply_filters" data-bs-dismiss="modal">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Candidate Modal -->
    <div class="modal fade" id="editCandidateModal" tabindex="-1" aria-labelledby="editCandidateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCandidateModalLabel">Edit Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCandidateForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_candidate_id" name="candidate_id">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_indexing">Exam Number</label>
                                    <input type="text" class="form-control" id="edit_indexing" name="indexing" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_programme_id">Test Code</label>
                                    <select class="form-control" id="edit_programme_id" name="programme_id" required>
                                        <option value="">Select Test Code</option>
                                        @foreach($testCodes as $testCode)
                                            <option value="{{ $testCode->id }}">{{ $testCode->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_firstname">First Name</label>
                                    <input type="text" class="form-control" id="edit_firstname" name="firstname" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_surname">Surname</label>
                                    <input type="text" class="form-control" id="edit_surname" name="surname" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_other_names">Other Names</label>
                                    <input type="text" class="form-control" id="edit_other_names" name="other_names">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_gender">Gender</label>
                                    <select class="form-control" id="edit_gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="edit_dob" name="dob" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_exam_year">Exam Year</label>
                                    <input type="number" class="form-control" id="edit_exam_year" name="exam_year" min="2020" max="2030" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_attempt">Attempt</label>
                                    <select class="form-control" id="edit_attempt" name="attempt" required>
                                        <option value="1">1st Attempt</option>
                                        <option value="2">2nd Attempt</option>
                                        <option value="3">3rd Attempt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_enabled">Status</label>
                                    <select class="form-control" id="edit_enabled" name="enabled" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="edit_registration_id">Registration ID</label>
                                    <input type="number" class="form-control" id="edit_registration_id" name="registration_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Candidate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Candidate Modal -->
    <div class="modal fade" id="viewCandidateModal" tabindex="-1" aria-labelledby="viewCandidateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCandidateModalLabel">View Candidate Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="candidate-details">
                        <!-- Candidate details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables CSS and JS with Responsive extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(function () {
            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#candidates-table')) {
                $('#candidates-table').DataTable().clear().destroy();
            }
            
            var table = $('#candidates-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("admin.candidates.manage.data") }}',
                    data: function (d) {
                        d.exam_year = $('#exam_year_filter').val();
                        d.programme_id = $('#programme_id_filter').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 1},
                    {data: 'passport', name: 'passport', orderable: false, searchable: false, responsivePriority: 2},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, responsivePriority: 1},
                    {data: 'indexing', name: 'indexing', responsivePriority: 1},
                    {data: 'fullname', name: 'fullname', orderable: false, responsivePriority: 2},
                    {data: 'gender', name: 'gender', responsivePriority: 4},
                    {data: 'dob', name: 'dob', responsivePriority: 5},
                    {data: 'test_code', name: 'test_code', orderable: false, responsivePriority: 3},
                    {data: 'exam_year', name: 'exam_year', responsivePriority: 3},
                    {data: 'attempt', name: 'attempt', responsivePriority: 6},
                    {data: 'status', name: 'status', orderable: false, searchable: false, responsivePriority: 2},
                    {data: 'registration_id', name: 'registration_id', responsivePriority: 7}
                ],
                pageLength: 50,
                lengthMenu: [25, 50, 100, 200],
                order: [[3, 'asc']],
                language: {
                    processing: "Loading candidates...",
                    emptyTable: "No candidates found.",
                    info: "Showing _START_ to _END_ of _TOTAL_ candidates",
                    infoEmpty: "Showing 0 to 0 of 0 candidates",
                    infoFiltered: "(filtered from _MAX_ total candidates)"
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            });

            // Apply filters
            $('#apply_filters').click(function() {
                table.draw();
            });

            // Clear filters
            $('#clear_filters').click(function() {
                $('#exam_year_filter').val('');
                $('#programme_id_filter').val('');
                table.draw();
            });

            // Pull candidates functionality
            $('#pull-candidates-btn').click(function() {
                var btn = $(this);
                var originalText = btn.html();
                
                // Disable button and show loading state
                btn.prop('disabled', true).html('<i class="las la-spinner fa-spin"></i> Pulling...');
                
                $.ajax({
                    url: '{{ route("admin.candidates.manage.pull") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            // Show success message
                            $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                response.message + 
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>').prependTo('.card-body');
                            
                            // Refresh the DataTable
                            table.draw();
                        } else {
                            // Show error message
                            $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                (response.message || 'Error pulling candidates') +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>').prependTo('.card-body');
                        }
                    },
                    error: function(xhr) {
                        // Show error message
                        var errorMessage = 'Error pulling candidates';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            errorMessage +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>').prependTo('.card-body');
                    },
                    complete: function() {
                        // Re-enable button and restore original text
                        btn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // View candidate
            $(document).on('click', '.view-candidate', function(e) {
                e.preventDefault();
                var candidateId = $(this).data('id');
                
                $.ajax({
                    url: '{{ route("admin.candidates.manage.show", "") }}/' + candidateId,
                    type: 'GET',
                    success: function(response) {
                        if(response.success) {
                            var candidate = response.candidate;
                            var html = `
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="bg-primary p-2 mb-3"><strong>Personal Information</strong></h6>
                                        <p><strong>Exam Number:</strong> ${candidate.indexing}</p>
                                        <p><strong>Full Name:</strong> ${candidate.firstname} ${candidate.surname} ${candidate.other_names || ''}</p>
                                        <p><strong>Gender:</strong> ${candidate.gender}</p>
                                        <p><strong>Date of Birth:</strong> ${candidate.dob}</p>
                                        <p><strong>NIN:</strong> ${candidate.nin || 'N/A'}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="bg-primary p-2 mb-3"><strong>Academic Information</strong></h6>
                                        <p><strong>Test Code:</strong> ${candidate.test_code}</p>
                                        <p><strong>Exam Year:</strong> ${candidate.exam_year}</p>
                                        <p><strong>Attempt:</strong> ${candidate.attempt}</p>
                                        <p><strong>Status:</strong> <span class="badge ${candidate.enabled ? 'bg-success' : 'bg-danger'}">${candidate.enabled ? 'Active' : 'Inactive'}</span></p>
                                        <p><strong>Registration ID:</strong> ${candidate.registration_id || 'N/A'}</p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="bg-primary p-2 mb-3"><strong>Scheduling Information</strong></h6>
                                        ${candidate.schedules.length > 0 ? 
                                            candidate.schedules.map(schedule => `
                                                <div class="card mb-2">
                                                    <div class="card-body">
                                                        <p class="mb-1"><strong>Subject:</strong> ${schedule.subject}</p>
                                                        <p class="mb-1"><strong>Centre:</strong> ${schedule.centre}</p>
                                                        <p class="mb-1"><strong>Venue:</strong> ${schedule.venue}</p>
                                                        <p class="mb-1"><strong>Test Session:</strong> ${schedule.test_config}</p>
                                                        <p class="mb-0"><strong>Date:</strong> ${schedule.date}</p>
                                                    </div>
                                                </div>
                                            `).join('') :
                                            '<p class="text-muted">No scheduling information available</p>'
                                        }
                                    </div>
                                </div>
                               
                            `;
                            
                            $('#candidate-details').html(html);
                            $('#viewCandidateModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        alert('Error fetching candidate details');
                    }
                });
            });

            // Edit candidate
            $(document).on('click', '.edit-candidate', function(e) {
                e.preventDefault();
                var candidateId = $(this).data('id');
                
                $.ajax({
                    url: '{{ route("admin.candidates.manage.show", "") }}/' + candidateId,
                    type: 'GET',
                    success: function(response) {
                        if(response.success) {
                            var candidate = response.candidate;
                            
                            // Populate form fields
                            $('#edit_candidate_id').val(candidate.id);
                            $('#edit_indexing').val(candidate.indexing);
                            $('#edit_firstname').val(candidate.firstname);
                            $('#edit_surname').val(candidate.surname);
                            $('#edit_other_names').val(candidate.other_names);
                            $('#edit_gender').val(candidate.gender);
                            $('#edit_dob').val(candidate.dob);
                            $('#edit_programme_id').val(candidate.programme_id);
                            $('#edit_exam_year').val(candidate.exam_year);
                            $('#edit_attempt').val(candidate.attempt);
                            $('#edit_enabled').val(candidate.enabled);
                            $('#edit_registration_id').val(candidate.registration_id);
                            
                            $('#editCandidateModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        alert('Error fetching candidate details');
                    }
                });
            });

            // Update candidate
            $('#editCandidateForm').on('submit', function(e) {
                e.preventDefault();
                var candidateId = $('#edit_candidate_id').val();
                var formData = $(this).serialize();
                
                $.ajax({
                    url: '{{ route("admin.candidates.manage.update", "") }}/' + candidateId,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#editCandidateModal').modal('hide');
                            
                            // Show success message
                            $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                response.message + 
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>').prependTo('.card-body');
                            
                            // Refresh the DataTable
                            table.draw();
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Error updating candidate';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            errorMessage +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>').prependTo('.card-body');
                    }
                });
            });

            // Delete candidate with SweetAlert
            $(document).on('click', '.delete-candidate', function(e) {
                e.preventDefault();
                var candidateId = $(this).data('id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin.candidates.manage.delete", "") }}/' + candidateId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if(response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    );
                                    
                                    // Refresh the DataTable
                                    table.draw();
                                }
                            },
                            error: function(xhr) {
                                var errorMessage = 'Error deleting candidate';
                                if(xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                
                                Swal.fire(
                                    'Error!',
                                    errorMessage,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // Cleanup DataTable on page unload
            $(window).on('beforeunload', function() {
                if ($.fn.DataTable.isDataTable('#candidates-table')) {
                    $('#candidates-table').DataTable().destroy();
                }
            });
        });
    </script>
@endsection