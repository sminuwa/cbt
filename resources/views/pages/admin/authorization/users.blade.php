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
                        <i class="las la-plus text-white"></i>Add User
                    </a>
               </div>
                </div>
                <div class="col-md-12">

                    <table class="table table-hover table-center mb-0" id="actionTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Display Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>{{$user->username}}</td>
                                <td>{{$user->display_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->enabled?"Active":"Inactive"}}</td>
                                <td>

                                    <a data-bs-toggle="modal" href="#"
                                       class="btn btn-info text-light btn-sm viewPerm"
                                       user-id="{{$user->id}}" username={{$user->username}}
                                       display-name='{{$user->display_name}}' email='{{$user->email}}' enabled='{{$user->enabled}}'>
                                        <i class="fa fa-download"></i> Edit
                                    </a>
                                    {{-- <a href="#"
                                       class="btn btn-info text-light btn-sm viewUsers" user-id="{{$user->id}}">
                                        <i class="fa fa-users"></i> Assign Role
                                    </a> --}}


                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4">
                                    <center>No User Records</center>
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
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route("admin.authorization.user.save")}}" method="post">
                   @csrf
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Username</label>
                                                <input type="text" name="username" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Display Name</label>
                                                <input type="text" name="display_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Email</label>
                                                <input type="text" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="mb-2" for="semester">Status</label>
                                                <select name="enabled" class="form-control" required>
                                                    <option value="">Select</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade custom-modal" id="edit_users">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route("admin.authorization.user.edit")}}" method="post">
                   @csrf
                   <input type="hidden" name="user_id" id="user_id">
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Username</label>
                                                <input type="text" name="username" class="form-control" value="" id="username" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Display Name</label>
                                                <input type="text" name="display_name" class="form-control" value="" id="display_name" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="session" class="mb-2">Email</label>
                                                <input type="text" name="email" class="form-control" value="{{$user->email}}" id="email" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="mb-2" for="semester">Status</label>
                                                <select name="enabled" class="form-control" id="enabled" required>
                                                    <option value="">Select</option>
                                                    <option value="1" >Active</option>
                                                    <option value="0" >Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Save User
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
                $("#username").val($(this).attr('username'));
                $("#display_name").val($(this).attr('display-name'));
                $("#email").val($(this).attr('email'));
                $("#enabled").val($(this).attr('enabled'));
                $("#user_id").val($(this).attr('user-id'));
                $("#edit_users").modal('show');

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
                    url:"{{route("admin.authorization.role.users")}}",
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
