<?php

namespace App\Http\Controllers;

use App\Exports\UserPostsExport;
use App\Models\Post;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserPostsController extends Controller
{
    public function index()
    {
        return view('user_posts.index');
    }

    public function getData(Request $request)
    {
        $filterByName = $request->input('filterByName');
        $filterByDate = $request->input('filterByDate');
        $sortByDate = $request->input('sortByDate');

        // Your logic to retrieve and filter posts and comments
        $data = Post::with(['user', 'comments'])
            ->whereHas('user', function ($query) use ($filterByName) {
                $query->where('name', 'like', '%' . $filterByName . '%');
            })
            ->where('created_at', 'like', '%' . $filterByDate . '%')
            ->orderBy('created_at', $sortByDate)
            ->get();

        return response()->json($data);
    }

    public function exportExcel()
    {
        return Excel::download(new UserPostsExport, 'user_posts.xlsx');
    }
}
