@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}
                <div class="card-header">{{ __('employees') }}
                    {{-- <div style="display:inline-block; float:right; ">
                        <input type="button" value="Add Employee">
                    </div> --}}
                </div>


                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if (isset($employeeEdit))
                        <form action="{{route('employees.update')}}" method="post">
                            @csrf
                            <input type="text" name="name" placeholder="name" value="{{$employeeEdit->name}}">
                            {{-- <input type="email" name="email" placeholder="email" value="{{$employeeEdit->email}}"> --}}
                            <input type="number" name="mobile" placeholder="mobile" value="{{$employeeEdit->mobile}}">
                            <select name="department" id="status">
                                <option value="it" {{$employeeEdit->department == 'it' ? 'selected' : ''}}>IT</option>
                                <option value="sales" {{$employeeEdit->department == 'sales' ? 'selected' : ''}}>Sales</option>
                                <option value="marketing" {{$employeeEdit->department == 'marketing' ? 'selected' : ''}}>Marketing</option>
                            </select>
                            <select name="status" id="status">
                                <option value="active" {{$employeeEdit->status == 'active' ? 'selected' : ''}}>active</option>
                                <option value="inactive" {{$employeeEdit->status == 'inactive' ? 'selected' : ''}}>inactive</option>
                            </select>
                            <input type="hidden" name="id" placeholder="id" value="{{$employeeEdit->id}}">
                            <input type="submit" name="submit" value="submit">
                        </form>
                    @else
                        <form action="{{route('employee.store')}}" method="post">
                            @csrf
                            <input type="text" name="name" placeholder="name">
                            <input type="email" name="email" placeholder="email">
                            <input type="number" name="mobile" placeholder="mobile">
                            <select name="department" id="department">
                                <option value="it">IT</option>
                                <option value="sales">Sales</option>
                                <option value="marketing">Marketing</option>
                            </select>
                            <select name="status" id="status">
                                <option value="active">active</option>
                                <option value="inactive">inactive</option>
                            </select>
                            <input type="submit" name="submit" value="submit">
                        </form>
                    @endif

                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    {{-- {{ __('You are logged in!') }} --}}

                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($employees as $key=> $employee)

                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->mobile}}</td>
                                <td>{{$employee->email}}</td>
                                <td>{{$employee->department}}</td>
                                <td>{{$employee->status}}</td>
                                <td><a href="{{route('home', $employee->id)}}"><input type="button" value="Edit"></a></td>
                            </tr>
                            
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
