@extends('layouts.candidate')

@section('content')
    <div class="clock" id="clock">02:00:00</div>
@endsection

@push('style')
    <style>
        .clock {
            font-size: 2rem;
            font-family: Arial, sans-serif;
            margin: 20px;
            color: green; /* Initial color set to green */
        }
    </style>

@endpush

@push('script')
    <script>

    </script>
@endpush
