<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\Subject;


class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'siswa')->count();
        $totalSubjects = Subject::count();
        $totalPackages = Package::count();
        // Tambahkan data lain yang relevan
        
        return view('admin.dashboard', compact('totalStudents', 'totalSubjects', 'totalPackages'));
    }
}