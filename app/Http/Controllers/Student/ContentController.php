<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Module;
use App\Models\Video;

class ContentController extends Controller
{
    public function showCategory(Category $category)
    {
        $category->load('subCategories.subjects');
        return view('student.content.category', compact('category'));
    }

    public function showSubject(Subject $subject)
    {
        $subject->load(['videos', 'modules', 'exams']);
        return view('student.content.subject', compact('subject'));
    }

    // Metode untuk showModule dan showVideo jika perlu halaman detail
    public function showModule(Module $module)
    {
        return view('student.content.module_show', compact('module'));
    }

    public function showVideo(Video $video)
    {
        // Extract YouTube video ID from URL
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->youtube_url, $match);
        $youtubeId = $match[1] ?? null;

        return view('student.content.video_show', compact('video', 'youtubeId'));
    }
}