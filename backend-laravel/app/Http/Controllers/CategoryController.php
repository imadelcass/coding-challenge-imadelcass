<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters(['name', 'parent_id'])
            ->paginate();

        return response()->json($categories);
    }
}

