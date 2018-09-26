<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    /**
     * PageController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function studentView()
    {
        return view('student.index');
    }

    public function studentRegister()
    {
        return view('student.register');
    }

    public function studentSingleView($id_number="")
    {
        return view('student.single')->with('id_number', $id_number);
    }

    public function studentUpdate($id_number="")
    {
        return view('student.update')->with('id_number', $id_number);
    }

    public function addViolations()
    {
        return view('violations.index');
    }

    public function viewViolation($id_number=null) {
        return view('violations.single')->with('id_number', $id_number);
    }
}
