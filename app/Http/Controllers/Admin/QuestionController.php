<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Exam $exam)
    {
        return view('admin.questions.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        $exam->questions()->create([
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('admin.exams.show', $exam)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
        ]);
        
        return redirect()->route('admin.exams.show', $question->exam_id)->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Question $question)
    {
        $examId = $question->exam_id;
        $question->delete();
        return redirect()->route('admin.exams.show', $examId)->with('success', 'Soal berhasil dihapus.');
    }
}
