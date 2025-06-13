<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Subject;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // Implementasi CRUD sama seperti ModuleController, ganti 'content' dengan 'youtube_url'
    public function index()
    {
        $videos = Video::with('subject')->latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.videos.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'youtube_url' => 'required|url',
        ]);

        Video::create($request->all());

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        $subjects = Subject::all();
        return view('admin.videos.edit', compact('video', 'subjects'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'youtube_url' => 'required|url',
        ]);

        $video->update($request->all());
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }
}