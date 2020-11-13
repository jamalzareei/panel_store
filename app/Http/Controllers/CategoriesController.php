<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function getSubCategories($col, $parent_id = 0)
    {
        # code...
        $col++;
        $categories = Category::select('id', 'name')
            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->when(($parent_id == 0 || $parent_id == null), function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->whereNull('deleted_at')
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
