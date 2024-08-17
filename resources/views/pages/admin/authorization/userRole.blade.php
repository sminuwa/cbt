

<table class="table">
    <tr>
        <th>#</th>
        <th>Username</th>
        <th>Display Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    <tbody>
        @forelse ($roleUsers as $roleUser)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$roleUser->username}}</td>
            <td>{{$roleUser->display_name}}</td>
            <td>{{$roleUser->email}}</td>
            <td>
                <a href="{{ route("toolbox.authorization.role.user.detach")}}" data-user-id ={{$roleUser->id}} data-role-id="{{$role_id}}" class="btn btn-primary btn-sm detachUser">
                    <i class="fa fa-trach"></i>
                    Detach
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <th colspan="5">
                <center>No User under this role</center>
            </th>
        </tr>
        @endforelse

    </tbody>
</table>

</div>
