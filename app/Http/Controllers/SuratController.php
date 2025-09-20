<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $surats = Surat::with('category')
            ->when($q, fn($query) => $query->where('title', 'like', "%".$q."%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('surats.index', [
            'surats' => $surats,
            'q' => $q,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('surats.form', [
            'surat' => new Surat(),
            'categories' => $categories,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|file|mimes:pdf|max:20480', // up to 20MB
        ]);

        $path = $request->file('file')->store('arsip', 'public');
        $validated['file_path'] = $path;

        $surat = Surat::create($validated);

        return redirect()->route('surats.index')
            ->with('success', 'Data berhasil disimpan');
    }

    public function show(Surat $surat)
    {
        return view('surats.show', compact('surat'));
    }

    public function edit(Surat $surat)
    {
        $categories = Category::orderBy('name')->get();
        return view('surats.form', [
            'surat' => $surat,
            'categories' => $categories,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('file')) {
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('arsip', 'public');
        }

        $surat->update($validated);

        return redirect()->route('surats.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy(Surat $surat)
    {
        if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
            Storage::disk('public')->delete($surat->file_path);
        }
        $surat->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('surats.index')->with('success', 'Data berhasil dihapus');
    }

    public function download(Surat $surat)
    {
        $absolutePath = Storage::disk('public')->path($surat->file_path);
        return response()->download($absolutePath, Str::slug($surat->title).'.pdf');
    }
}
