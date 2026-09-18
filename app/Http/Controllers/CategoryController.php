<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Mostra gli annunci per una specifica categoria
     */
    public function show($slug)
    {
        // Cerca la categoria tramite lo "slug" (es. 'cucina')
        $category = Category::where('slug', $slug)->firstOrFail();

        // Prende tutti gli annunci attivi di questa categoria
        $listings = Listing::where('category_id', $category->id)
                           ->where('status', 'active')
                           ->with(['user', 'jobType'])
                           ->latest()
                           ->paginate(12);

        return view('categories.show', compact('category', 'listings'));
    }
}