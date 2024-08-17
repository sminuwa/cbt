@extends('layouts.app')

@section('css')
    <style>
        .loading-icon {
            display: none;
        }

        .lds-facebook,
        .lds-facebook span {
            box-sizing: border-box;
        }

        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 24px;
            height: 24px;
        }

        .lds-facebook span {
            display: inline-block;
            position: absolute;
            left: 0px;
            width: 6px;
            background: currentColor;
            background: #1891d2;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }

        .lds-facebook span:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }

        .lds-facebook span:nth-child(2) {
            left: 18px;
            animation-delay: -0.12s;
        }

        .lds-facebook span:nth-child(3) {
            left: 28px;
            animation-delay: 0s;
        }

        @keyframes lds-facebook {
            0% {
                top: 0px;
                height: 12px;
            }
            50%, 100% {
                top: 8px;
                height: 24px;
            }
        }


    </style>
@endsection
@section('content')
    @if(session()->has('success'))
        @if(!session('success'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endif
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Authorization/User Management</span>

                    </h4>
                </div>
                <div class="col-md-6">
                   <div class="pull-right">
                    <a data-bs-toggle="modal" href="#add_new_config" class="btn btn-primary btn-xs px-3">
                        <i class="las la-plus text-white"></i>Add Role
                    </a>
                    <a data-bs-toggle="modal" href="#add_permission" class="btn btn-primary btn-xs px-3">
                        <i class="las la-plus text-white"></i>Add Permission
                    </a>
               </div>
                </div>
                <div class="col-md-12">

                    <table class="table table-hover table-center mb-0" id="actionTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>{{$role->name}}</td>
                                <td>{{$role->description}}</td>
                                <td>

                                    <a href="#"
                                       class="btn btn-info text-light btn-sm viewPerm" role-id="{{$role->id}}">
                                        <i class="fa fa-download"></i> Permissions
                                    </a>
                                    <a href="#"
                                       class="btn btn-info text-light btn-sm viewUsers" role-id="{{$role->id}}">
                                        <i class="fa fa-users"></i> Users
                                    </a>


                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4">
                                    <center>No Records</center>
                                </th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="row mt-3">

    </div>

    <div class="modal fade custom-modal" id="add_new_config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route("toolbox.authorization.role.save")}}" method="post">
                   @csrf
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Role</label>
                                                <input type="text" name="role" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="mb-2" for="semester">Description</label>
                                                <input type="text" name="description" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade custom-modal" id="add_permission">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route("toolbox.authorization.permission.save")}}" method="post" >
                    @csrf
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Permission</label>
                                                <input type="text" name="permission" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="mb-2" for="semester">Description</label>
                                                <input type="text" name="description" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Save Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade custom-modal" id="manage_users">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Role Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route("toolbox.authorization.role.user.save")}}" method="post" >
                    @csrf
                    <input type="hidden" name="role_id" id="ru_role_id">
                    <div class="modal-body" >
                        <div style="border: 1px solid #666;border-radius:4px;padding:4px;margin-bottom:24px;">
                            <h3>Select Users to Add</h3>
                            <div class="form-group">
                                <label for="">User</label>
                                <select name="user_ids[]" id="usertoAddToRole" class="form-control select2" multiple>
                                    <option value="">Select...</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="table-responsive" style="height: 320px;overflow-y:scroll;" id="roleUsersLoad">

                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light" style="display:none;" id="addUserBtn">Add Users
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade custom-modal" id="permissions">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route("toolbox.authorization.role.permission.save")}}" method="post">
                    @csrf
                    <input type="hidden" name="role_id" id="mdx_role_id" value="">
                   <div class="modal-body" id="rolePermLoad">

                   </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/datatables.min.js"></script>
    <script src="/assets/swal.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
            $('#actionTable').DataTable({
                "bFilter": false,
                paging: false,
                ordering: false,
                searching: false,
                info: false  // Disable info display
            });

            $("body").on("change","#usertoAddToRole",function(e){
                $("#addUserBtn").show();
            });
            $(".viewPerm").on('click',function(){
                // alert(1);
                $("#permissions").modal('show');
                role_id = $(this).attr('role-id');
                $("#mdx_role_id").val(role_id);
                $.ajax({
                    url:"{{route("toolbox.authorization.role.permission")}}",
                    data:{role_id:role_id},
                    type:"get",
                    success:function(data){
                        $("#rolePermLoad").html(data);

                    }

                });
            });

            $("body").on('click','.detachUser',function(e){
                e.preventDefault(); // Prevent the default action
                var userId = $(this).data('user-id');
                var roleId = $(this).data('role-id');
                var url = $(this).attr('href');
                console.log();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to detach the user from this role?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, detach it!',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Make the AJAX call
                        detachUserRole(userId, roleId,url);
                    }
                });
            });

            $(".viewUsers").on('click',function(){
                // alert(1);
                $("#manage_users").modal('show');
                role_id = $(this).attr('role-id');
                $("#ru_role_id").val(role_id);
                loadUser(role_id);

            });

            function detachUserRole(userId, roleId,url) {
                // var url = '/your-api-endpoint'; // Replace with your API endpoint

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        user_id: userId,
                        role_id: roleId,
                        _token:"{{csrf_token()}}" // Laravel CSRF token
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            loadUser(role_id);
                            Swal.fire(
                                'Detached!',
                                'The user has been detached from the role.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem detaching the user from the role.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was a problem with the request.',
                            'error'
                        );
                    }
                });
            }

            function loadUser(roleId){
                $.ajax({
                    url:"{{route("toolbox.authorization.role.users")}}",
                    data:{role_id:roleId},
                    type:"get",
                    success:function(data){
                        $("#roleUsersLoad").html(data);

                    }

                });
            }
        });
    </script>
@endsection
