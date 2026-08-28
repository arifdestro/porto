<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Display a listing of portfolios.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('sort_order')->get();

        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new portfolio.
     */
    public function create()
    {
        return view('admin.portfolios.create');
    }

    /**
     * Store a newly created portfolio.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'    => 'nullable|string|max:100',
            'link'        => 'nullable|url',
            'is_active'   => 'boolean',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']);
        $data['is_active'] = $request->boolean('is_active');

        // Handle image upload — convert to WebP and resize
        if ($request->hasFile('image')) {
            $data['image'] = ImageHelper::processAndSave(
                $request->file('image'),
                'uploads/portfolios',
                1000,
                82
            );
        }

        $data['sort_order'] = Portfolio::max('sort_order') + 1;

        Portfolio::create($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio created successfully.');
    }

    /**
     * Show the form for editing the specified portfolio.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified portfolio.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'    => 'nullable|string|max:100',
            'link'        => 'nullable|url',
            'is_active'   => 'boolean',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']);
        $data['is_active'] = $request->boolean('is_active');

        // Handle image replacement — convert to WebP and resize
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($portfolio->image && file_exists(public_path($portfolio->image))) {
                unlink(public_path($portfolio->image));
            }

            $data['image'] = ImageHelper::processAndSave(
                $request->file('image'),
                'uploads/portfolios',
                1000,
                82
            );
        } else {
            unset($data['image']);
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio updated successfully.');
    }

    /**
     * Remove the specified portfolio.
     */
    public function destroy(Portfolio $portfolio)
    {
        // Delete the image file
        if ($portfolio->image && file_exists(public_path($portfolio->image))) {
            unlink(public_path($portfolio->image));
        }

        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio deleted successfully.');
    }

    /**
     * Update sort order via AJAX drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            Portfolio::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
