<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Category::class)
            ->select([
                'id',
                'name',
                'parent_id',
            ]);

        if ($request->has('all')) {
            return $query->get();
        }

        $query = $query
            ->allowedFilters([
                AllowedFilter::exact('trainee.code'),
            ])
            ->latest()
            ->paginate();

        return response()->json($query);
    }
}
