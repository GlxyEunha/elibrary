@extends('librarian.layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Update Book</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <!-- Tambahkan enctype untuk mendukung upload file -->
                    <form class="yourform" action="{{ route('librarian.book.update', $book->id) }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Book Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Book Name" name="name" value="{{ $book->name }}">
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $book->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <select class="form-control @error('author_id') is-invalid @enderror" name="author_id">
                                <option value="">Select Author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ $author->id == $book->auther_id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Publisher</label>
                            <select class="form-control @error('publisher_id') is-invalid @enderror" name="publisher_id">
                                <option value="">Select Publisher</option>
                                @foreach ($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ $publisher->id == $book->publisher_id ? 'selected' : '' }}>
                                        {{ $publisher->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('publisher_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cover Image</label>
                            <!-- Tampilkan gambar saat ini jika tersedia -->
                            @if ($book->cover_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover Image" width="100">
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('cover_image') is-invalid @enderror" name="cover_image">
                            @error('cover_image')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Synopsis</label>
                            <textarea class="form-control @error('sinopsis') is-invalid @enderror" name="sinopsis" rows="5"
                                placeholder="Enter book synopsis">{{ old('sinopsis', $book->sinopsis) }}</textarea>
                            @error('sinopsis')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>                        
                        <input type="submit" name="save" class="btn btn-danger" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
