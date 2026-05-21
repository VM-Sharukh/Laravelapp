@extends('layouts.app')

@section('content')
    {{-- @dump($getUserDetails) --}}
    

    <div class="container-fluid">
        {{-- @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <h2>Add User</h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.add-user-details') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name">
                            @error('name')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="email">
                            @error('email')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>  

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="salary">Salary:</label>
                            <input type="text" name="salary" value="{{ old('salary') }}" class="form-control" id="salary">
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
                </div>
                <br>
                @csrf
                @method('POST')
                <button type='submit' class='btn btn-success'>Add User</button>
                <a type="button" class="btn btn-primary" href="{{ route('users.user-list')}}">
                    User List
                </a>
            </form>
            </div>
        </div>
    </div>

@endsection