
    <div class="row">
        <div class="col-md-6">Permission</div>
        <div class="col-md-6">Permission</div>
        <div class="col-md-12">
            <hr>
        </div>
        @foreach ($permissions as $permission)
        <div class="col-md-6">
            <input type="checkbox" name="permissions[]" value="{{$permission->id}}" {{ in_array($permission->id,$rolePermissions)?"checked":"" }}>
            <div style="display: inline-block;">
                {{$permission->description}}
            </div>
        </div>
        @endforeach
    </div>
