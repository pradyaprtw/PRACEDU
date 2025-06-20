<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->withCount('subjects')->latest()->paginate(10);
        return view('admin.sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            // Tambahkan validasi manual unique per kategori
        ]);

        $normalizedName = strtolower($request->name);

        $exists = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [$normalizedName])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Sub Kategori dengan nama tersebut sudah ada dalam kategori yang sama.'])->withInput();
        }

        SubCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $normalizedName = strtolower($request->name);

        $exists = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [$normalizedName])
            ->where('id', '<>', $subCategory->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Sub Kategori dengan nama tersebut sudah ada dalam kategori yang sama.'])->withInput();
        }

        $subCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->subjects()->count() > 0) {
            return back()->with('error', 'Sub Kategori tidak dapat dihapus karena memiliki mata pelajaran.');
        }
        $subCategory->delete();
        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub Kategori berhasil dihapus.');
    }
}