@foreach($subjects as $subject)
    <div class="doc-slot-list"
         style="background-color: #1d75b3;border: 1px solid #1d75b3;">
        {{ $subject->subject_code }} - {{ $subject->name   }}
        <a href="javascript:void(0)" data-id="{{ $subject->id }}"
           class="delete_schedule">
            <i class="fa fa-check text-light"></i>
        </a>
    </div>
@endforeach
