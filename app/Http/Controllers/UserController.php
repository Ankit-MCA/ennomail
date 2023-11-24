<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Post;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsExport;


class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $posts = $user->posts()->with('comments')->latest();

        // Apply filters
        if ($request->has('filter_user')) {
            $posts->where('user_id', $request->filter_user);
        }

        if ($request->has('filter_date')) {
            $posts->whereDate('created_at', $request->filter_date);
        }

        // Apply sorting
        if ($request->has('sort')) {
            $sortOrder = $request->sort == 'asc' ? 'asc' : 'desc';
            $posts->orderBy('created_at', $sortOrder);
        }

        $posts = $posts->paginate(10);

        $posts = $user->posts()->with('comments')->latest()->paginate(10);

        return view('dashboard', compact('user', 'posts'));
    }

    public function exportExcel(Request $request)
{
    $user = Auth::user();
    $posts = $user->posts()->with('comments')->latest()->get();

    $excelFile = Excel::download(new PostsExport($posts), 'posts.xlsx');

    return $excelFile;
}
}
