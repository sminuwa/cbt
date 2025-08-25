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
                        <span>Manage Centres</span>
                    </h4>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCentreModal">
                        <i class="las la-plus"></i> Add Centre
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addVenueModal">
                        <i class="las la-plus"></i> Add Venue
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Centres Table -->
            <div class="table-responsive">
                <table id="centres-table" class="display table table-striped table-hover nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Actions</th>
                            <th>Centre Name</th>
                            <th>Location</th>
                            <th>Venues</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via DataTables Ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Centre Modal -->
    <div class="modal fade" id="addCentreModal" tabindex="-1" aria-labelledby="addCentreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCentreModalLabel">Add Centre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCentreForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="centre_name">Centre Name</label>
                                    <input type="text" class="form-control" id="centre_name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="centre_location">Centre Location</label>
                                    <input type="text" class="form-control" id="centre_location" name="centreLocation" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="centre_api_key">API Key</label>
                                    <input type="text" class="form-control" id="centre_api_key" name="api_key" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="centre_secret_key">Secret Key</label>
                                    <input type="text" class="form-control" id="centre_secret_key" name="secret_key" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Centre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Venue Modal -->
    <div class="modal fade" id="addVenueModal" tabindex="-1" aria-labelledby="addVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVenueModalLabel">Add Venue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addVenueForm">
                    <div class="modal-body">
                        <input type="hidden" id="venue_id" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="venue_centre">Centre</label>
                                    <select class="form-control" id="venue_centre" name="center" required>
                                        <option value="">Select Centre</option>
                                        @foreach($centres as $centre)
                                            <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="venue_name">Venue Name</label>
                                    <input type="text" class="form-control" id="venue_name" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="venue_location">Venue Location</label>
                                    <input type="text" class="form-control" id="venue_location" name="venueLocation" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="venue_capacity">Venue Capacity</label>
                                    <input type="number" class="form-control" id="venue_capacity" name="capacity" min="1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Venue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Centre Modal -->
    <div class="modal fade" id="editCentreModal" tabindex="-1" aria-labelledby="editCentreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCentreModalLabel">Edit Centre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCentreForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_centre_id" name="centre_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_centre_name">Centre Name</label>
                                    <input type="text" class="form-control" id="edit_centre_name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_centre_location">Centre Location</label>
                                    <input type="text" class="form-control" id="edit_centre_location" name="location" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_centre_api_key">API Key</label>
                                    <input type="text" class="form-control" id="edit_centre_api_key" name="api_key" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_centre_secret_key">Secret Key</label>
                                    <input type="text" class="form-control" id="edit_centre_secret_key" name="secret_key" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Centre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Centre Modal -->
    <div class="modal fade" id="viewCentreModal" tabindex="-1" aria-labelledby="viewCentreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCentreModalLabel">View Centre Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="centre-details">
                        <!-- Centre details will be loaded here -->
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
    
    <style>
        .transition-transform {
            transition: transform 0.2s ease;
        }
        
        .btn[aria-expanded="true"] .la-angle-down {
            transform: rotate(180deg);
        }
        
        .btn[aria-expanded="false"] .la-angle-down {
            transform: rotate(0deg);
        }
    </style>
    <script>
        $(function () {
            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#centres-table')) {
                $('#centres-table').DataTable().clear().destroy();
            }
            
            var table = $('#centres-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("admin.centres.manage.data") }}',
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 1},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, responsivePriority: 1},
                    {data: 'name', name: 'name', responsivePriority: 1},
                    {data: 'location', name: 'location', responsivePriority: 2},
                    {data: 'venues_count', name: 'venues_count', orderable: false, searchable: false, responsivePriority: 3},
                    {data: 'status', name: 'status', orderable: false, searchable: false, responsivePriority: 2},
                    {data: 'created_at', name: 'created_at', responsivePriority: 4}
                ],
                pageLength: 50,
                lengthMenu: [25, 50, 100, 200],
                order: [[2, 'asc']],
                language: {
                    processing: "Loading centres...",
                    emptyTable: "No centres found.",
                    info: "Showing _START_ to _END_ of _TOTAL_ centres",
                    infoEmpty: "Showing 0 to 0 of 0 centres",
                    infoFiltered: "(filtered from _MAX_ total centres)"
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            });

            // Add Centre functionality
            $('#addCentreForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                
                $.ajax({
                    url: '{{ route("admin.toolbox.center_venue.center.store") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addCentreModal').modal('hide');
                        
                        // Show success message
                        $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            'Centre added successfully!' + 
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>').prependTo('.card-body');
                        
                        // Reset form
                        $('#addCentreForm')[0].reset();
                        
                        // Refresh the DataTable
                        table.draw();
                    },
                    error: function(xhr) {
                        var errorMessage = 'Error adding centre';
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

            // Add Venue functionality
            $('#addVenueForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                
                $.ajax({
                    url: '{{ route("admin.toolbox.center_venue.venue.store") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addVenueModal').modal('hide');
                        
                        // Show success message
                        $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            'Venue added successfully!' + 
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>').prependTo('.card-body');
                        
                        // Reset form
                        $('#addVenueForm')[0].reset();
                        
                        // Refresh the DataTable
                        table.draw();
                    },
                    error: function(xhr) {
                        var errorMessage = 'Error adding venue';
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

            // View centre
            $(document).on('click', '.view-centre', function(e) {
                e.preventDefault();
                var centreId = $(this).data('id');
                
                console.log('Viewing centre ID:', centreId); // Debug log

                $.ajax({
                    url: '{{ route("admin.centres.manage.show", "") }}/' + centreId,
                    type: 'GET',
                    beforeSend: function() {
                        $('#centre-details').html('<p>Loading centre details...</p>');
                    },
                    success: function(response) {
                        console.log('Centre details response:', response); // Debug log
                        // Build venues list
                        var venuesHtml = '';
                        if (response.venues && response.venues.length > 0) {
                            venuesHtml = response.venues.map(venue => 
                                `<div class="badge bg-info me-1 mb-1">${venue.name} (${venue.capacity} seats)</div>`
                            ).join('');
                        } else {
                            venuesHtml = '<span class="text-muted">No venues configured</span>';
                        }

                        // Build candidates by paper
                        var candidatesHtml = '';
                        if (response.scheduled_candidates && Object.keys(response.scheduled_candidates).length > 0) {
                            Object.keys(response.scheduled_candidates).forEach((subjectCode, index) => {
                                var candidates = response.scheduled_candidates[subjectCode];
                                var subjectName = candidates[0].subject_name;
                                var accordionId = `accordion-${subjectCode.replace(/[^a-zA-Z0-9]/g, '')}-${index}`;
                                var collapseId = `collapse-${subjectCode.replace(/[^a-zA-Z0-9]/g, '')}-${index}`;
                                
                                candidatesHtml += `
                                    <div class="card mb-3">
                                        <div class="card-header bg-light" id="heading-${accordionId}">
                                            <h6 class="mb-0">
                                                <button class="btn btn-link text-decoration-none p-0 d-flex justify-content-between align-items-center w-100 text-start" 
                                                        type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#${collapseId}" 
                                                        aria-expanded="${index === 0 ? 'true' : 'false'}" 
                                                        aria-controls="${collapseId}">
                                                    <span><strong>${subjectCode} - ${subjectName}</strong> (${candidates.length} candidates)</span>
                                                    <i class="las la-angle-down transition-transform"></i>
                                                </button>
                                            </h6>
                                        </div>
                                        <div id="${collapseId}" 
                                             class="collapse ${index === 0 ? 'show' : ''}" 
                                             aria-labelledby="heading-${accordionId}">
                                            <div class="card-body p-2">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Exam No.</th>
                                                                <th>Full Name</th>
                                                                <th>Venue</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>`;
                                
                                candidates.forEach(candidate => {
                                    var fullName = `${candidate.firstname} ${candidate.surname}`;
                                    if (candidate.other_names) {
                                        fullName += ` ${candidate.other_names}`;
                                    }
                                    
                                    var scheduleDate = new Date(candidate.schedule_date).toLocaleDateString();
                                    var startTime = candidate.daily_start_time ? new Date('1970-01-01T' + candidate.daily_start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A';
                                    var endTime = candidate.daily_end_time ? new Date('1970-01-01T' + candidate.daily_end_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A';
                                    
                                    candidatesHtml += `
                                        <tr>
                                            <td><strong>${candidate.indexing}</strong></td>
                                            <td>${fullName}</td>
                                            <td>${candidate.venue_name}</td>
                                            <td>${scheduleDate}</td>
                                            <td>${startTime} - ${endTime}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-candidate" 
                                                            data-candidate-id="${candidate.candidate_id}" 
                                                            data-schedule-id="${candidate.id}" 
                                                            title="Delete candidate">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary reschedule-candidate" 
                                                            data-candidate-id="${candidate.candidate_id}" 
                                                            data-schedule-id="${candidate.id}" 
                                                            title="Reschedule candidate">
                                                        <i class="las la-exchange-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>`;
                                });
                                
                                candidatesHtml += `
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            });
                        } else {
                            candidatesHtml = '<div class="alert alert-info">No candidates scheduled for this centre yet.</div>';
                        }

                        var html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="bg-primary p-2 mb-3"><strong>Centre Information</strong></h6>
                                    <p><strong>Name:</strong> ${response.name}</p>
                                    <p><strong>Location:</strong> ${response.location}</p>
                                    <p><strong>Status:</strong> <span class="badge ${response.status == 'Active' ? 'bg-success' : 'bg-danger'}">${response.status}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="bg-primary p-2 mb-3"><strong>API Configuration</strong></h6>
                                    <p><strong>API Key:</strong> ${response.api_key || 'N/A'}</p>
                                    <p><strong>Secret Key:</strong> ${response.secret_key || 'N/A'}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="p-2 mb-3"><strong>Venues</strong></h6>
                                    <div class="mb-3">${venuesHtml}</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="p-2 mb-3"><strong>Scheduled Candidates by Paper</strong></h6>
                                    ${candidatesHtml}
                                </div>
                            </div>
                        `;
                        
                        $('#centre-details').html(html);
                        $('#viewCentreModal').data('current-centre-id', centreId);
                        $('#viewCentreModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Error fetching centre details');
                    }
                });
            });

            // Edit centre
            $(document).on('click', '.edit-centre', function(e) {
                e.preventDefault();
                var centreId = $(this).data('id');
                
                $.ajax({
                    url: '{{ route("admin.centres.manage.show", "") }}/' + centreId,
                    type: 'GET',
                    success: function(response) {
                        // Populate form fields
                        $('#edit_centre_id').val(response.id);
                        $('#edit_centre_name').val(response.name);
                        $('#edit_centre_location').val(response.location);
                        $('#edit_centre_api_key').val(response.api_key);
                        $('#edit_centre_secret_key').val(response.secret_key);
                        
                        $('#editCentreModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Error fetching centre details');
                    }
                });
            });

            // Update centre
            $('#editCentreForm').on('submit', function(e) {
                e.preventDefault();
                var centreId = $('#edit_centre_id').val();
                var formData = $(this).serialize();
                
                $.ajax({
                    url: '{{ route("admin.centres.manage.update", "") }}/' + centreId,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#editCentreModal').modal('hide');
                            
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
                        var errorMessage = 'Error updating centre';
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

            // Delete centre with SweetAlert
            $(document).on('click', '.delete-centre', function(e) {
                e.preventDefault();
                var centreId = $(this).data('id');
                var centreName = $(this).data('name');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete centre "${centreName}". This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin.centres.manage.destroy", "") }}/' + centreId,
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
                                var errorMessage = 'Error deleting centre';
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

            // Delete candidate handler
            $(document).on('click', '.delete-candidate', function(e) {
                e.preventDefault();
                var candidateId = $(this).data('candidate-id');
                var scheduleId = $(this).data('schedule-id');
                var row = $(this).closest('tr');
                var candidateName = row.find('td:nth-child(2)').text();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete candidate "${candidateName}" from this schedule. This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete candidate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin.centres.manage.candidate.delete") }}',
                            type: 'POST',
                            data: {
                                candidate_id: candidateId,
                                schedule_id: scheduleId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if(response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    ).then(() => {
                                        // Refresh the current centre view
                                        $('.view-centre[data-id="' + $('#viewCentreModal').data('current-centre-id') + '"]').click();
                                    });
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
            
            // Reschedule candidate handler
            $(document).on('click', '.reschedule-candidate', function(e) {
                e.preventDefault();
                var candidateId = $(this).data('candidate-id');
                var scheduleId = $(this).data('schedule-id');
                var row = $(this).closest('tr');
                var candidateName = row.find('td:nth-child(2)').text();
                
                console.log('Reschedule clicked for candidate:', candidateId, 'schedule:', scheduleId);
                
                // First, get available centres
                $.ajax({
                    url: '{{ route("admin.centres.manage.available") }}',
                    type: 'GET',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading available centres...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(centres) {
                        console.log('Available centres response:', centres);
                        if (centres.length === 0) {
                            Swal.fire('Info', 'No other centres available for rescheduling.', 'info');
                            return;
                        }
                        
                        // Build options for centre selection
                        var centreOptions = centres.map(centre => 
                            `<option value="${centre.id}">${centre.name} - ${centre.location}</option>`
                        ).join('');
                        
                        Swal.fire({
                            title: `Reschedule "${candidateName}"`,
                            html: `
                                <div class="form-group mb-3">
                                    <label for="new-centre" class="form-label">Select New Centre:</label>
                                    <select id="new-centre" class="form-control">
                                        <option value="">-- Select Centre --</option>
                                        ${centreOptions}
                                    </select>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Reschedule',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const newCentreId = document.getElementById('new-centre').value;
                                if (!newCentreId) {
                                    Swal.showValidationMessage('Please select a centre');
                                    return false;
                                }
                                return newCentreId;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var newCentreId = result.value;
                                
                                // Perform reschedule
                                $.ajax({
                                    url: '{{ route("admin.centres.manage.candidate.reschedule") }}',
                                    type: 'POST',
                                    data: {
                                        candidate_id: candidateId,
                                        schedule_id: scheduleId,
                                        new_centre_id: newCentreId
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        if(response.success) {
                                            Swal.fire(
                                                'Rescheduled!',
                                                response.message,
                                                'success'
                                            ).then(() => {
                                                // Refresh the current centre view
                                                $('.view-centre[data-id="' + $('#viewCentreModal').data('current-centre-id') + '"]').click();
                                            });
                                        }
                                    },
                                    error: function(xhr) {
                                        var errorMessage = 'Error rescheduling candidate';
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
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        
                        var errorMessage = 'Failed to load available centres.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 404) {
                            errorMessage = 'Route not found (404). Please check the route configuration.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error (500). Please check the server logs.';
                        }
                        
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            // Cleanup DataTable on page unload
            $(window).on('beforeunload', function() {
                if ($.fn.DataTable.isDataTable('#centres-table')) {
                    $('#centres-table').DataTable().destroy();
                }
            });
        });
    </script>
@endsection
