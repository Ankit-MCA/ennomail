@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-4">Welcome, {{ $user->name }}!</h1>

        <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
            <div class="row">
            
                <div class="col-md-4">
                    <label for="filter_date">Filter by Date:</label>
                    <input type="date" name="filter_date" value="{{ request('filter_date') }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="sort">Sort by Date:</label>
                    <select name="sort" class="form-control">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Latest First</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Apply Filters</button>
           
        </form>
        <button id="exportExcelBtn" class="btn btn-success mt-2">Export to Excel</button>

        
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->created_at }}</h5>
                            <p class="card-text">{{ $post->content }}</p>

                            <ul class="list-group list-group-flush">
                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item">{{ $comment->content }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $posts->links() }}
    </div>

   

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#exportExcelBtn').click(function () {
            $.ajax({
                url: '{{ route('export.excel') }}',
                method: 'GET',
                success: function (data) {
                    // Your logic to handle the exported data
                    console.log('Exported data:', data);
                    alert('Exported to Excel successfully!');
                },
                error: function (xhr, status, error) {
                    alert('Error exporting to Excel: ' + error);
                }
            });
        });
    });
</script>
@endsection
