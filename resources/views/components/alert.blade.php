@if(session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session()->has('success'))
    <div class="alert alert-danger">{{ session('success') }}</div>
@endif
