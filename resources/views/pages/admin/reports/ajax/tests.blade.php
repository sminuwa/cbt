<option value="">Select</option>
@foreach($configs as $config)
    <option value="{{$config->id}}">{{$config->title}} - {{$config->session}} - {{$config->test_code->name}}
        / {{$config->test_type->name}}</option>
@endforeach
