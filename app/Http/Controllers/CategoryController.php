<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.form', [
            'category' => new Category(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);
        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil disimpan');
    }

    public function edit(Category $category)
    {
        return view('categories.form', [
            'category' => $category,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);
        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil disimpan');
    }

    public function destroy(Category $category)
    {
        if ($category->surats()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }
        $category->delete();
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
