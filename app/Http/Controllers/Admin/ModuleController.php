<?php
// File: app/Http/Controllers/Admin/ModuleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk mengelola file

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
            'document' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // Maks 10MB
        ]);

        // Simpan file ke storage/app/public/modules
        $filePath = $request->file('document')->store('modules', 'public');

        Module::create([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diunggah.');
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
            'document' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // Boleh kosong saat update
        ]);

        $filePath = $module->file_path;

        // Jika ada file baru yang diunggah
        if ($request->hasFile('document')) {
            // Hapus file lama
            Storage::disk('public')->delete($module->file_path);
            // Simpan file baru
            $filePath = $request->file('document')->store('modules', 'public');
        }

        $module->update([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        // Hapus file dari storage sebelum menghapus record dari database
        Storage::disk('public')->delete($module->file_path);
        
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus.');
    }
}
