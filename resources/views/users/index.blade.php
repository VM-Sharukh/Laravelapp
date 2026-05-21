@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
    <div class="container-fluid">

        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <h2>User List</h2>
                    </div>
                    <div class="col-md-9">
                        <a type="button" class="btn btn-lg btn-success float-md-end" href="{{ route('users.add-user')}}">
                            Add
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Salary</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getUserList as $user)
                            
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->salary }}</td>
                                <td>
                                    <a type="button" class="btn btn-sm btn-success" 
                                        href="{{ route('users.fetch-details', Crypt::encryptString($user->id))}}"
                                        >
                                        Edit
                                    </a>

                                    <button class="btn btn-sm btn-info changeStatus" data-id="{{ $user->id }}" 
                                        data-status="{{ $user->status }}"> 
                                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                     </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            // 'pageLength' : 10,
            'order' : [['0','desc']]

        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $("#csrf_token").val()
        }
    });

    $('.changeStatus').click(function(){
        let button = $(this);
        let userId = button.data('id');
        let currentStatus = button.data('status');
        let newStatus = currentStatus == 1 ? 0 : 1;
        $.ajax({
            url:"{{ route('users.update-user-status') }}",
            type:"POST",
            data:{
                user_id:userId,
                status:newStatus
            },
            success:function(response){
                if(response.success){
                    button.text(newStatus == 1 ? 'Active': 'Inactive');
                    button.data('status',newStatus);
                    alert(response.message);
                }
            },
            error:function(){
                alert('Something went wrong');
            }

        });
    });
</script>
@endpush