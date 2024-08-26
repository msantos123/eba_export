<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name as department')
        ->join('departments', 'departments.id','=','employees.department_id')
        ->paginate(10);

        $departments = Department::all();
        return Inertia::render('Employees/Index',['employees'=>$employee,
        'departments'=>$departments]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:150',
            'email'=>'required|max:80',
            'phone'=>'required|max:15',
            'department_id'=>'required|numeric',
        ]);
        $employee = new Employee($request->input());
        $employee->save();
        return redirect('employees');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'=>'required|max:150',
            'email'=>'required|max:80',
            'phone'=>'required|max:15',
            'department_id'=>'required|numeric',
        ]);
        $employee->update($request->input());
        return redirect('employees');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function EmployeeByDepartment()
    {
        $data = Employee::select(DB::raw('count(employees.id) as count, departments.name'))
        ->join('departments', 'departments.id','=','employees.department_id')
        ->groupBy('departments.name')
        ->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports(){
        $employee = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'department_id', 'departments.name as department')
        ->join('departments', 'departments.id','=','employees.department_id')
        ->paginate(10);

        $departments = Department::all();
        return Inertia::render('Employees/Reports',['employees'=>$employee,
        'departments'=>$departments]);
    }
}
