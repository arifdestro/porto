<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of social links.
     */
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order')->get();

        return view('admin.social-links.index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new social link.
     */
    public function create()
    {
        return view('admin.social-links.create');
    }

    /**
     * Store a newly created social link.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform'   => 'required|string|max:255',
            'url'        => 'required|url|max:255',
            'icon'       => 'required|string|max:255',
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = SocialLink::max('sort_order') + 1;

        SocialLink::create($validated);

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Social link created successfully.');
    }

    /**
     * Show the form for editing the specified social link.
     */
    public function edit(SocialLink $socialLink)
    {
        return view('admin.social-links.edit', compact('socialLink'));
    }

    /**
     * Update the specified social link.
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform'   => 'required|string|max:255',
            'url'        => 'required|url|max:255',
            'icon'       => 'required|string|max:255',
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $socialLink->update($validated);

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Social link updated successfully.');
    }

    /**
     * Remove the specified social link.
     */
    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Social link deleted successfully.');
    }

    /**
     * Update sort order via AJAX drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            SocialLink::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
