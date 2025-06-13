<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::with('subCategories')->get();
        $subscription = Subscription::where('user_id', Auth::id())
                                    ->where('end_date', '>=', now())
                                    ->with('package')
                                    ->first();

        return view('student.dashboard', compact('categories', 'subscription'));
    }
}