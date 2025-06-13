<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('subject')->withCount('questions')->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.exams.create', compact('subjects'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'duration' => 'required|integer|min:1',
        ]);

        Exam::create($request->all());
        return redirect()->route('admin.exams.index')->with('success', 'Ujian berhasil dibuat.');
    }

    // `show` digunakan untuk menampilkan detail ujian dan daftar soalnya
    public function show(Exam $exam)
    {
        $exam->load('questions');
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $subjects = Subject::all();
        return view('admin.exams.edit', compact('exam', 'subjects'));
    }
    
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'duration' => 'required|integer|min:1',
        ]);
        $exam->update($request->all());
        return redirect()->route('admin.exams.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy(Exam $exam)
    {
        $exam->questions()->delete(); // Hapus semua soal terkait
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Ujian dan semua soalnya berhasil dihapus.');
    }
}
