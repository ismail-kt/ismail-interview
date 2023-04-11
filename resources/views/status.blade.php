@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}
                <div class="card-header">{{ __('assign employee') }}
                    {{-- <div style="display:inline-block; float:right; ">
                        <input type="button" value="Add Employee">
                    </div> --}}
                </div>


                <div class="card-body">



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

                        <form action="{{route('status.update')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$task->id}}">
                            <select name="status" id="status">
                                <option value="unassigned" {{$task->status == 'unassigned' ? 'selected' : ''}}>unassigned</option>
                                <option value="assigned" {{$task->status == 'assigned' ? 'selected' : ''}}>assigned</option>
                                <option value="inprogress" {{$task->status == 'inprogress' ? 'selected' : ''}}>inprogress</option>
                                <option value="done" {{$task->status == 'done' ? 'selected' : ''}}>done</option>
                            </select>
                            <input type="submit" name="submit" value="submit">
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
