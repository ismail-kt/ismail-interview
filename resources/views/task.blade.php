@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}
                <div class="card-header">{{ __('tasks') }}
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
                
                    {{-- <hr> --}}
                    Search
                    <form action="{{route('task.show')}}" method="get">
                       
                        <select name="employee" id="employee">
                            <option value="">NA</option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                        <select name="status" id="status">
                            <option value="">NA</option>
                            <option value="unassigned">unassigned</option>
                            <option value="assigned">assigned</option>
                            <option value="inprogress">inprogress</option>
                            <option value="done">done</option>
                        </select>
                        <input type="submit" name="submit" value="Search">
                        <a href="{{route('task.show')}}"><input type="button" name="button" value="Reset"></a>
                    </form>
                    <hr>
                    Add or Edit
                    @if (isset($taskEdit))
                        <form action="{{route('task.update')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" placeholder="id" value="{{$taskEdit->id}}">
                            <input type="text" name="title" placeholder="title" value="{{$taskEdit->title}}">
                            <input type="text" name="description" placeholder="description" value="{{$taskEdit->description}}">
                            {{-- <input type="number" name="employee" placeholder="mobile"> --}}
                            <select name="employee_id" id="employee_id">
                                <option value="">NA</option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}" {{$taskEdit->employee_id == $employee->id ? 'selected' : ''}}>{{$employee->name}}</option>
                                @endforeach
                            </select>
                            <select name="status" id="status">
                                <option value="unassigned" {{$taskEdit->status == 'unassigned' ? 'selected' : ''}}>unassigned</option>
                                <option value="assigned" {{$taskEdit->status == 'assigned' ? 'selected' : ''}}>assigned</option>
                                <option value="inprogress" {{$taskEdit->status == 'inprogress' ? 'selected' : ''}}>inprogress</option>
                                <option value="done" {{$taskEdit->status == 'done' ? 'selected' : ''}}>done</option>
                            </select>
                            <input type="submit" name="submit" value="submit">
                        </form>
                    @else
                        <form action="{{route('task.store')}}" method="post">
                            @csrf
                            <input type="text" name="title" placeholder="title">
                            <input type="text" name="description" placeholder="description">
                            <select name="employee_id" id="employee_id">
                                <option value="">NA</option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                            <select name="status" id="status">
                                <option value="unassigned">unassigned</option>
                                <option value="assigned">assigned</option>
                                <option value="inprogress">inprogress</option>
                                <option value="done">done</option>
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
                    <hr>
                    

                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Employee</th>
                            <th>Status</th>
                            <th>Started Time</th>
                            <th>Edit</th>
                            <th>Assign</th>
                            <th>Status Update</th>
                        </tr>
                        @foreach ($tasks as $key=> $task)

                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$task->title}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->employee->name??'NA'}}</td>
                                <td>{{$task->status}}</td>
                                <td>{{$task->started}}</td>
                                <td><a href="{{route('task.show', $task->id)}}"><input type="button" value="Edit"></a></td>
                                <td><a href="{{route('task.assign', $task->id)}}"><input type="button" value="Assign"></a></td>
                                <td><a href="{{route('task.status', $task->id)}}"><input type="button" value="change"></a></td>
                            </tr>
                            
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
