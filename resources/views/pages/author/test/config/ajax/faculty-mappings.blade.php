<div class="col-8 col-lg-8 col-xl-8 col-md-12">
    <div class="card border-info">
        <div class="card-header border-info">
            Faculty Mappings
        </div>
        <div class="card-body pt-0">
            <table class="table table-striped table-bordered mt-3">
                <thead>
                <tr>
                    <th style="width: 10%">#</th>
                    <th>Faculty</th>
                    <th style="width: 10%">Mapping</th>
                </tr>
                </thead>
                <tbody>
                @foreach($faculties as $faculty)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $faculty->name }}</td>
                    <td align="center">
                        <input type="checkbox" name="mapped[]" {{$faculty->mapped?'checked':''}}
                        value="{{ $faculty->id }}">
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3 pt-3 d-flex justify-content-between">
                <a class="btn btn-warning text-light"
                   href="{{ route('admin.test.config.view',[$config_id]) }}"><i
                        class="fa fa-arrow-left me-1"></i>Back</a>
                <input id="submit" class="btn btn-info text-light" type="submit" value="Save Changes">
            </div>
        </div>
    </div>
</div>
