<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\UserExamAttempt;
use App\Models\UserExamAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentExamController extends Controller
{
    // Halaman "lobby" sebelum memulai ujian
    public function show(Exam $exam)
    {
        $exam->loadCount('questions');
        return view('student.exams.show', compact('exam'));
    }

    // Memulai sesi ujian baru
    public function start(Request $request, Exam $exam)
    {
        $user = Auth::user();

        // Cek jika ada attempt yang belum selesai untuk ujian ini
        $ongoingAttempt = UserExamAttempt::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if ($ongoingAttempt) {
             // Cek apakah waktu sudah habis
            $startTime = Carbon::parse($ongoingAttempt->start_time);
            $endTime = $startTime->addMinutes($exam->duration);
            if (now()->gt($endTime)) {
                // Jika waktu sudah habis, selesaikan ujian secara otomatis
                $this->submit($request, $ongoingAttempt);
                return redirect()->route('siswa.exam.result', $ongoingAttempt)->with('error', 'Waktu pengerjaan sebelumnya telah habis.');
            }
            return redirect()->route('siswa.exam.simulation', $ongoingAttempt);
        }

        // Buat record attempt baru
        $attempt = UserExamAttempt::create([
            'user_id' => $user->id,
            'exam_id' => $exam->id,
            'start_time' => now(),
            'status' => 'in_progress',
        ]);

        return redirect()->route('siswa.exam.simulation', $attempt);
    }

    // Halaman simulasi ujian
    public function simulation(UserExamAttempt $userExamAttempt)
    {
        // Pastikan attempt masih 'in_progress'
        if ($userExamAttempt->status !== 'in_progress') {
            return redirect()->route('siswa.exam.result', $userExamAttempt)->with('error', 'Ujian ini telah selesai.');
        }
        
        $userExamAttempt->load('exam.questions');
        $startTime = Carbon::parse($userExamAttempt->start_time);
        $durationInSeconds = $userExamAttempt->exam->duration * 60;
        $endTime = $startTime->addSeconds($durationInSeconds);
        $remainingSeconds = now()->diffInSeconds($endTime, false);

        if ($remainingSeconds <= 0) {
            // Jika waktu habis, submit otomatis
             return $this->submit(new Request(), $userExamAttempt);
        }
        
        return view('student.exams.simulation', compact('userExamAttempt', 'remainingSeconds'));
    }
    
    // Proses submit jawaban
    public function submit(Request $request, UserExamAttempt $userExamAttempt)
    {
         if ($userExamAttempt->status === 'completed') {
            return redirect()->route('siswa.exam.result', $userExamAttempt);
        }

        $answers = $request->input('answers', []);
        $questions = $userExamAttempt->exam->questions;
        $correctCount = 0;

        DB::transaction(function () use ($answers, $questions, &$correctCount, $userExamAttempt) {
            foreach ($questions as $question) {
                $userAnswerIndex = $answers[$question->id] ?? null;
                $isCorrect = ($userAnswerIndex !== null && $question->correct_answer == $userAnswerIndex);

                if ($isCorrect) {
                    $correctCount++;
                }
                
                // Simpan jawaban user
                UserExamAnswer::updateOrCreate(
                    [
                        'user_exam_attempt_id' => $userExamAttempt->id,
                        'question_id' => $question->id,
                    ],
                    ['user_answer' => $userAnswerIndex]
                );
            }

            // Hitung skor
            $totalQuestions = $questions->count();
            $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;

            // Update record attempt
            $userExamAttempt->update([
                'score' => $score,
                'end_time' => now(),
                'status' => 'completed',
            ]);
        });
        
        return redirect()->route('siswa.exam.result', $userExamAttempt);
    }
    
    // Halaman hasil ujian
    public function result(UserExamAttempt $userExamAttempt)
    {
        if ($userExamAttempt->status !== 'completed') {
            return redirect()->route('siswa.dashboard')->with('error', 'Ujian belum diselesaikan.');
        }

        $userExamAttempt->load('exam.questions', 'answers.question');

        return view('student.exams.result', compact('userExamAttempt'));
    }
}