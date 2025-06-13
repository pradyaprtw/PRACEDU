<?php

// Controller untuk mengelola Mata Pelajaran.

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('subCategory.category')->latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subCategories = SubCategory::all();
        return view('admin.subjects.create', compact('subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        Subject::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sub_category_id' => $request->sub_category_id,
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }
    
    // Metode edit, update, destroy mirip dengan CategoryController
    // Pastikan untuk mengambil data subCategories di metode edit juga.
    public function edit(Subject $subject)
    {
        $subCategories = SubCategory::all();
        return view('admin.subjects.edit', compact('subject', 'subCategories'));
    }
    
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        $subject->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sub_category_id' => $request->sub_category_id,
        ]);
        
        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject)
    {
        // Tambahkan validasi relasi (jika punya modul, video, ujian)
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}