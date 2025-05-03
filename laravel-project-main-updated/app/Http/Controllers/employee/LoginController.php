<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function ShowLoginForm()
    {
        // $subrats = Aeemployee::latest()->get();

        return view('employee.employee_login');
    }
    public function ShowLoginEmp()
    {
        return view('employee.employee_login_page');
    } //End method
    public function LogOutEmp()
    {
        return view('employee.employee_login');
    } //End method
}
