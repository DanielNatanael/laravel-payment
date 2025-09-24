<!DOCTYPE html>
<html>
<head>
    <title>Blog List</title>
</head>
<body>
    <h1>Blog List</h1>

    <ul>
        @foreach($blogs as $blog)
            <li>
                <h2>{{ $blog->title }}</h2>
                <p><strong>Category:</strong> {{ $blog->category }}</p>
                <p><strong>Total Views:</strong> {{ $blog->total_views }}</p>
                <p>{{ $blog->description }}</p>
                <a href="/blogs/{{ $blog->id }}/edit">Edit</a>


              <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" style="display: inline-block" onclick="return confirm('Are you sure you want to delete this blog?');">
                Delete
            </button>
        </form>
            </li>
        @endforeach
    </ul>

</body>
</html>