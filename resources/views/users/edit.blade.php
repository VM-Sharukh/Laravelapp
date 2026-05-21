@extends('layouts.app')

@section('content')
    <!-- @dump($getUserDetails) -->
    

    <div class="panel panel-default">
        @if(session('success'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="panel-heading">
            <!-- <h3 class="panel-title">Submit Form</h3> -->
            <h1>User Details : {{ $getUserDetails->name }} </h1>
        </div>
        <div class="panel-body">
            <form action="{{ route('users.update-details',Crypt::encryptString($getUserDetails->id)) }}" 
            method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="{{ $getUserDetails->name }}" class="form-control" id="name">
                            @error('name')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" value="{{ $getUserDetails->email }}" class="form-control" id="email">
                            @error('email')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>  

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="salary">Salary:</label>
                            <input type="text" name="salary" value="{{ $getUserDetails->salary }}" class="form-control" id="salary">
                            @error('salary')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>  

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="profile_img">Profile Image:</label>
                            <input type="file" name="profile_img" class="form-control" id="profile_img">
                            @error('profile_img')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 

                    
                    <input type="hidden" name="old_profile_img" value="{{ $getUserDetails->profile_img }}">
                    <input type="hidden" name="old_profile_img_name" value="{{ $getUserDetails->profile_img_name }}">
                    <input type="hidden" name="old_profile_img_type" value="{{ $getUserDetails->profile_img_type }}">
                    <input type="hidden" name="old_profile_img_data" value="{{ $getUserDetails->profile_img_data }}">


                    @if(!empty($getImageBase64))
                        <div class="col-md-6">
                        <img src="data:{{ $getUserDetails->profile_img_type }};base64,{{ $getImageBase64 }}"
                             class="img-thumbnail" >
                        </div>

                    @endif
                </div>
                <br>
                @csrf
                @method('PUT')
                <button type='submit' class='btn btn-success'>Update User</button>
                <a type="button" class="btn btn-primary" href="{{ route('users.user-list')}}">
                    User List
                </a>
            </form>
        </div>
    </div>

@endsection