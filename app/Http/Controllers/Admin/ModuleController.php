<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Subject;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('subject')->latest()->paginate(10);
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.modules.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'content' => 'required|string',
        ]);

        Module::create($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil ditambahkan.');
    }
    
    public function edit(Module $module)
    {
        $subjects = Subject::all();
        return view('admin.modules.edit', compact('module', 'subjects'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'content' => 'required|string',
        ]);

        $module->update($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus.');
    }
}