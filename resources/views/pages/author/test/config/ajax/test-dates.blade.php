@if(count($dates))
    <div class="doc-times pt-3">
        @foreach($dates as $date)
            <div class="doc-slot-list" style="background-color: #1d75b3;border: 1px solid #1d75b3;">
                {{ \Carbon\Carbon::parse($date->date)->format('D jS M, Y') }}
                <a href="javascript:void(0)" data-id="{{ $date->id }}" class="delete_schedule">
                    <i class="fa fa-times text-light"></i>
                </a>
            </div>
        @endforeach
    </div>
@else
    <div style="width:100%;height: 100%;display: flex;justify-content: center;align-items: center"
         class="pt-4">
        No date added
    </div>
@endif
