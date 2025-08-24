@if(count($subjects))
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-primary">
            <tr>
                <th style="width: 10%">#</th>
                <th>Code</th>
                <th>Name</th>
                <th style="width: 20%; text-align: center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($subjects as $subject)
                <tr class="paper-row">
                    <td class="align-middle">
                        <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                    </td>
                    <td class="align-middle">
                        <strong class="text-primary">{{ $subject->subject_code }}</strong>
                    </td>
                    <td class="align-middle">
                        <span class="paper-name">{{ $subject->name }}</span>
                    </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-sm btn-outline-primary delete_schedule" 
                                data-id="{{ $subject->id }}" 
                                title="Add paper to test">
                            <i class="las la-plus me-1"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <!-- This will be handled by the main template's empty state -->
@endif
