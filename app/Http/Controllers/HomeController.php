<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\task;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'department' => 'required',
            'mobile' => 'required|number|max:10',
            'status' => 'required',
        ]);

            $employee = new employee([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'department' => $request->input('department'),
            'mobile' => $request->input('mobile'),
            'status' => $request->input('status'),
        ]);

        $employee->save();

        //return to view 
    }

    public function editEmployee($id)
    {
        $task = employee::find($id);
        //return employee data to edit view
    }

    public function updateEmployee(Request $request)
    {
        $request->validate([
            'id' =>'required',
            'name' => 'required|string|max:255',
            'department' => 'required',
            'mobile' => 'required|number|max:10',
            'status' => 'required',
        ]);

        $employee = employee::find($request->id);
        $employee->name = $request->input('name');
        $employee->department = $request->input('department');
        $employee->mobile = $request->input('mobile');
        $employee->status = $request->input('status');
        $employee->save();

        //return to view 
    }

    public function viewEployees()
    {
        // getting all employees
        $employee = employee::all();
        //result passing to view
    }

    public function storeTasks(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|email|unique:users|max:255',
            // 'employee_id' => 'required|number',
            'status' => 'required',
        ]);

            $task = new task([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'employee_id' => $request->input('employee_id'),
            'status' => $request->input('status'),
        ]);

        $task->save();
       //return to view
    } 

    public function viewTasks()
    {
        // getting all employees
        $employee = task::all();
        // result passing to view
    }

    public function editTask($id)
    {
        $task = task::find($id);
        //return task data to edit view
    }

    public function updateTasks(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|email|unique:users|max:255',
            'status' => 'required',
        ]);

        $task = task::find($request->id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->employee_id = $request->input('employee_id');
        $task->status = $request->input('status');
        $task->save();

        //return to view 
    }

    public function assignTask(Request $request)
    {
        $task = task::find($request->id);
        $task->employee_id = $request->input('employee_id');
        $task->status = 'assigned';
        $task->save();
    }


    public function assigneeChange(Request $request)
    {
        $task = task::find($request->id);
        if ($task->status=='assigned') {
            $task->employee_id = $request->input('employee_id');
            $task->save();
        }else{
            //return error 'task is in progress'
        }
        //return success message and view
    }

    public function startTask(Request $request){
        $currentDateTime = now()->format('Y-m-d H:i:s');
        $task = task::find($request->id);
        $task->status = 'inprogress';
        $task->started = $currentDateTime;
        $task->save();
    }

    public function completeTask(Request $request){
        $currentDateTime = now()->format('Y-m-d H:i:s');
        $task = task::find($request->id);
        $startedTime = $task->started;
        $timeDifferenceInMinutes = $startedTime->diffInMinutes($currentDateTime);
        if (($task->status=='inprogress')&&($timeDifferenceInMinutes > 5)) {
            $task->status = 'done';
            $task->save();
        }else{
            //return error 'please submit the task after 5 minutes'
        }
        //return success
    }
}
