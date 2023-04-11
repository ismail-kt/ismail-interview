<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use DateTime;
use Carbon\Carbon;


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
    public function index($id='')
    {
        $employees = Employee::all();
        if ($id) {
            $employeeEdit = Employee::find($id);
            return view('home')->with('employees', $employees)->with('employeeEdit', $employeeEdit);
        }

        return view('home')->with('employees', $employees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'department' => 'required',
            'status' => 'required',
            'mobile' => 'required|numeric',
        ]);
            
            $employee = new Employee;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->department = $request->department;
            $employee->status = $request->status;
            $employee->mobile = $request->mobile;
            $employee->save();

        //return to view
        session()->flash('success', 'created new employee successfully!');
        return redirect()->route('home');
        // return redirect(route('home')); 
    }

    public function editEmployee($id)
    {
        $task = Employee::find($id);
        //return employee data to edit view
    }

    public function updateEmployee(Request $request)
    {
        // dd($request);
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'department' => 'required',
            'status' => 'required',
            'mobile' => 'required',
        ]);

        $employee = Employee::find($request->id);
        $employee->name = $request->name;
        $employee->department = $request->department;
        $employee->status = $request->status;
        $employee->mobile = $request->mobile;
        $employee->save();
        //return to view 
        // return redirect(route('home'));
        session()->flash('success', 'updated successfully!');
        return redirect()->route('home');
    }

    public function viewTasks(Request $request, $id='')
    {
        // die('kkk');
        $taskData = Task::query();
        if ($request->employee) {
            $taskData->where('employee_id',$request->employee);
        }
        if ($request->status) {
            $taskData->where('status',$request->status);
        }

        $task = $taskData->get();
        $employees = Employee::all();
        if ($id) {
            $taskEdit = Task::find($id);
            $task = Task::all();
            return view('task')->with('tasks', $task)->with('employees', $employees)->with('taskEdit', $taskEdit);
        }
        return view('task')->with('tasks', $task)->with('employees', $employees);
    }


    public function storeTasks(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            // 'employee_id' => 'required',
            'status' => 'required',
        ]);

        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->employee_id = $request->employee_id;
        $task->status = $request->status;
        $task->save();

        try {
            $this->sendEmail('admin@otaskit.com', 'task is added', 'hello there, new task is added','hello@otaskit.com', 'otaskit.com');
        } catch (\Throwable $th) {
            //throw $th;
        }
        // return redirect(route('task.show'));
        session()->flash('success', 'created new task successfully!');
        return redirect()->route('task.show');
    }

    public function updateTasks(Request $request)
    {
        // dd($request);
        $request->validate([
            'id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $task = Task::find($request->id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->employee_id = $request->input('employee_id');
        $task->status = $request->input('status');
        $task->save();

        session()->flash('success', 'updated task successfully!');
        return redirect()->route('task.show');
        // return redirect(route('task.show'));
    }

    
    public function assignTask(Request $request)
    {
        $employees = Employee::all();
        $task = Task::find($request->id);
        return view('assign')->with('employees', $employees)->with('task', $task);   
    }


    public function assignTaskSubmit(Request $request)
    {
        $task = Task::find($request->id);
        if (($task->status == 'unassigned') || ($task->status == 'assigned') ) {

            $task->employee_id = $request->employee_id;
            $task->status = 'unassigned';
            $task->started = NULL;
            if ($request->employee_id) {
                $task->status = 'assigned';
                $task->save();

                $assigneeEmail = $task->employee->email;

                try {
                    $this->sendEmail($assigneeEmail, 'task is added', 'hello there, new task is added','hello@otaskit.com', 'otaskit.com');
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }else{
            $error = "can't update tasks with inprogress status";
            session()->flash('error', 'Validation error occurred!');
            return redirect()->back()->withErrors($error); 
        }
        // return redirect(route('task.show'));
        session()->flash('success', 'assigned task successfully!');
        return redirect()->route('task.show');
    }

    public function taskStatus(Request $request)
    {
        $task = Task::find($request->id);
        return view('status')->with('task', $task);   
    }
 

    public function statusTaskSubmit(Request $request){
        // $currentDateTime = now()->format('Y-m-d H:i:s');
        $currentDate = Carbon::now();
        $task = Task::find($request->id);

        if ($request->status == 'done') {
            $started_at = $task->started;
            // $dateObject = timestamp::createFromFormat('Y-m-d H:i:s', $started_at);
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $started_at);
            $timeDifferenceInMinutes = $date->diffInMinutes($currentDate);
            if (($task->status=='inprogress')&&($timeDifferenceInMinutes > 5)) {
                $task->status = 'done';
            }else{
                $error = 'completion is possible only after 5 mins of in progress';
                session()->flash('error', 'Validation error occurred!');
                return redirect()->back()->withErrors($error); 
            }
        }elseif ($request->status == 'inprogress') {
                $task->status = $request->status;
                $task->started = $currentDate;
        }else {
            $task->status = $request->status;
        }
        $task->save();

        // return redirect(route('task.show'));
        session()->flash('success', 'updated task status successfully!');
        return redirect()->route('task.show');   
    }

    function sendEmail($to, $subject, $body, $from, $name) {
        Mail::send([], [], function ($message) use ($to, $subject, $body) {
            $message->to($to);
            $message->subject($subject);
            $message->setBody($body, 'text/html');
            $message->from('your_email@example.com', 'Your Name');
            $message->sender('your_email@example.com', 'Your Name');
            $message->replyTo('your_email@example.com', 'Your Name');
    
            $message->getSwiftMessage()
                ->getHeaders()
                ->addTextHeader('X-Mailer', 'Laravel Mailer');
        });
    }


}
