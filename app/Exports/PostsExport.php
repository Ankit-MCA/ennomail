<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Post;

class PostsExport implements FromCollection
{
    public function collection()
    {
        // Replace this with your actual query to retrieve posts data
        return Post::all();
    }
}
