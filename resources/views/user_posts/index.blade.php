<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">

<ul>
    <!-- Other menu items... -->

    @auth
    
        <li>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <h5>{{ Auth::user()->name }}</h5> 
                <button type="submit">Logout</button>
            </form>
        </li>
    @endauth
</ul>
    <!-- Filter and Sort Options -->
    <div class="form-row mb-3">
        <div class="col">
            <label for="filterByName">Filter by Name:</label>
            <input type="text" id="filterByName" name="filterByName" class="form-control">
        </div>
        <div class="col">
            <label for="filterByDate">Filter by Date:</label>
            <input type="date" id="filterByDate" name="filterByDate" class="form-control">
        </div>
        <div class="col">
            <label for="sortByDate">Sort by Date:</label>
            <select id="sortByDate" name="sortByDate" class="form-control">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
    </div>

    <!-- Posts Container -->
    <div id="posts-container" class="col-md-8">
        <!-- Posts will be loaded here -->
    </div>
</div>

<script>
    $(document).ready(function () {
        loadPostsData();

        $('#filterByName, #filterByDate, #sortByDate').change(function () {
            loadPostsData();
        });

        function loadPostsData() {
            var filterByName = $('#filterByName').val();
            var filterByDate = $('#filterByDate').val();
            var sortByDate = $('#sortByDate').val();

            $.ajax({
                url: '{{ route('user.posts.data') }}',
                method: 'GET',
                data: {
                    filterByName: filterByName,
                    filterByDate: filterByDate,
                    sortByDate: sortByDate
                },
                success: function (data) {
                    // Clear existing content
                    $('#posts-container').html('');

                    // Iterate through the posts
                    if (data.length === 0) {
                        // Display a message when no records are found
                        $('#posts-container').html('<p>No records found.</p>');
                    } else {
                    data.forEach(function (post) {
                        var postHtml = '<div class="card mb-3">';
                        postHtml += '<div class="card-body">';
                        postHtml += '<p>ID: ' + post.id + '</p>';
                        postHtml += '<p>User ID: ' + post.user_id + '</p>';
                        postHtml += '<p>User Name: ' + post.user.name + '</p>';
                        postHtml += '<p>Content: ' + post.content + '</p>';
                        postHtml += '<p>Created At: ' + post.created_at + '</p>';

                        // Check if comments exist
                        if (post.comments.length > 0) {
                            postHtml += '<ul>';
                            post.comments.forEach(function (comment) {
                                postHtml += '<li>ID: ' + comment.id + ', Content: ' + comment.content + '</li>';
                            });
                            postHtml += '</ul>';
                        }

                        postHtml += '</div>';
                        postHtml += '</div>';

                        // Append post HTML to container
                        $('#posts-container').append(postHtml);
                    });
                }
                },
                error: function (xhr, status, error) {
                    console.error('Error loading data:', error);
                }
            });
        }
    });
</script>

</body>
</html>
