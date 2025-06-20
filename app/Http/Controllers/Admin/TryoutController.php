<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TryoutPackage;
use App\Models\Subtest;
use App\Models\TryoutQuestion;
use App\Models\TryoutAnswer;

class TryoutController extends Controller
{
    public function index()
    {
        $packages = TryoutPackage::with('subtests')->paginate(10);
        return view('admin.tryout.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.tryout.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TryoutPackage::create($request->all());

        return redirect()->route('admin.tryout.index')->with('success', 'Paket tryout berhasil dibuat.');
    }

    public function show(TryoutPackage $tryoutPackage)
    {
        $tryoutPackage->load('subtests');
        return view('admin.tryout.show', compact('tryoutPackage'));
    }

    public function destroy(TryoutPackage $tryoutPackage)
    {
        $tryoutPackage->delete();
        return redirect()->route('admin.tryout.index')->with('success', 'Paket tryout berhasil dihapus.');
    }

    // Subtest CRUD
    public function createSubtest(TryoutPackage $tryoutPackage)
    {
        return view('admin.subtests.create', compact('tryoutPackage'));
    }

    public function storeSubtest(Request $request, TryoutPackage $tryoutPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_questions' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $tryoutPackage->subtests()->create($request->all());

        return redirect()->route('admin.tryout.show', $tryoutPackage)->with('success', 'Subtest berhasil ditambahkan.');
    }

    public function destroySubtest(TryoutPackage $tryoutPackage, Subtest $subtest)
    {
        $subtest->delete();
        return redirect()->route('admin.tryout.show', $tryoutPackage)->with('success', 'Subtest berhasil dihapus.');
    }

    // Question CRUD
    public function createQuestion(Subtest $subtest)
    {
        return view('admin.tryout.questions.create', compact('subtest'));
    }

    public function storeQuestion(Request $request, Subtest $subtest)
    {
        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D',
            'option_labels' => 'required|array|size:4',
            'option_texts' => 'required|array|size:4',
            'explanation' => 'nullable|string',
        ]);

        // Cek apakah sudah mencapai batas maksimal soal
        $currentCount = $subtest->tryoutQuestions()->count();
        if ($currentCount >= $subtest->total_questions) {
            return redirect()->back()->withErrors(['Jumlah soal sudah mencapai batas maksimal untuk subtest ini!']);
        }

        // 1. Simpan soalnya dulu
        $question = $subtest->tryoutQuestions()->create([
            'question_text' => $request->question_text,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
        ]);

        // 2. Simpan semua opsi jawaban
        foreach ($request->option_labels as $index => $label) {
            $question->answers()->create([
                'option_label' => $label,
                'answer_text' => $request->option_texts[$index],
                'is_correct' => $label === $request->correct_answer,
            ]);
        }

        return redirect()->route('admin.tryout.show', $subtest->package_id)
            ->with('success', 'Soal beserta pilihan jawaban berhasil ditambahkan.');
    }



    public function destroyQuestion(Subtest $subtest, TryoutQuestion $tryoutQuestion)
    {
        $tryoutQuestion->delete();
        return redirect()->route('admin.tryout.show', $subtest->package_id)->with('success', 'Soal berhasil dihapus.');
    }

    // Answer CRUD
    public function createAnswer(TryoutQuestion $tryoutQuestion)
    {
        return view('admin.tryout.answers.create', compact('tryoutQuestion'));
    }

    public function storeAnswer(Request $request, TryoutQuestion $tryoutQuestion)
    {
        $request->validate([
            'option_label' => 'required|string|max:1',
            'answer_text' => 'required|string',
            'is_correct' => 'boolean',
        ]);

        $tryoutQuestion->answers()->create($request->all());

        return redirect()->route('admin.tryout.show', $tryoutQuestion->subtest->package_id)->with('success', 'Jawaban berhasil ditambahkan.');
    }

    public function destroyAnswer(TryoutQuestion $tryoutQuestion, TryoutAnswer $tryoutAnswer)
    {
        $tryoutAnswer->delete();
        return redirect()->route('admin.tryout.show', $tryoutQuestion->subtest->package_id)->with('success', 'Jawaban berhasil dihapus.');
    }
}
