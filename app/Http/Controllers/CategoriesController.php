<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    //
    public function getSubCategories($col, $parent_id = 0)
    {
        # code...
        
        $user = Auth::user();

        $seller = $user->seller;
        $websites_id = $seller->websites->pluck('id')->toArray();
        
        $col++;
        $categories = Category::whereNull('deleted_at')
            // ->select('id', 'name')
            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->when(($parent_id == 0 || $parent_id == null), function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->with('websites')
            ->whereHas('websites', function($query) use($websites_id){
                $query->whereIn('website_id', $websites_id);
            })
            ->whereNotNull('actived_at')
            ->withCount('children')
            ->get();


        return view('components.products.load-categories', [
            'categories' => $categories,
            'col' => $col,
        ])->render();
        return $categories;
    }
}
