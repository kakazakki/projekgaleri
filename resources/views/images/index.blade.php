@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Image Upload</h2>
    <form action="{{ url('/images/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    <hr>

    <h2>Uploaded Images</h2>
    <div class="row">
        @foreach($images as $image)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->title }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $image->title }}</h5>
                        <!-- Button trigger modal -->
                        <form action="{{ route('images.delete', $image->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                     <!-- Inside the foreach loop -->
<form action="{{ route('images.like', $image->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-info">Like</button>
</form>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
