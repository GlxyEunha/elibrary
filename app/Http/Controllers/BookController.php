<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\auther;
use App\Models\category;
use App\Models\publisher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorebookRequest;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatebookRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexg()
     {
 
        $book = Book::paginate(6);
        $categories = Category::all();

        return view('dashboard', [
            'books' => $book,
            'categories' => $categories
        ]);
     }

    public function search(Request $request)
     {
        $query = $request->input('q');

        $books = Book::where('name', 'LIKE', '%' . $query . '%') 
            ->orWhereHas('auther', function ($q) use ($query) { 
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->paginate(6);

        return view('dashboard', compact('books', 'query'));
     }
     

     public function index()
     {
         return view('librarian.book.index', [
             'books' => Book::paginate(5)
         ]);
     }

     public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('librarian.book.book_detail', compact('book'));
    }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('librarian.book.create', [
             'authors' => Auther::latest()->get(),
             'publishers' => Publisher::latest()->get(),
             'categories' => Category::latest()->get(),
         ]);
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(StoreBookRequest $request)
     {
         $number = mt_rand(10000000,99999999);

         if ($this->productCodeExists($number)) {
            $number = mt_rand(10000000,99999999);
         }
         // Initialize the book data array with the validated request data
         $bookData = $request->validated() + [
            'product_code' => $number,
            'status' => 'Y',
            'sinopsis' => $request->input('sinopsis')];
 
         // Handle the cover image upload if it exists
        //  if ($request->hasFile('cover_image')) {
        //      $coverPath = $request->file('cover_image')->store('images', 'public');
        //      $bookData['cover_image'] = $coverPath;
        //  }
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension(); // Generate unique name
            $image->move(public_path('images'), $imageName); // Move file to public/images
            $bookData['cover_image'] = 'images/' . $imageName; // Save the relative path in the database
        }
 
         // Create the book with the data
         Book::create($bookData);
 
         return redirect()->route('librarian.books')->with('success', 'Book added successfully.');
     }

     public function productCodeExists($number) {
        return Book::whereProductCode($number)->exists();
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Book $book)
     {
         return view('librarian.book.edit', [
             'authors' => Auther::latest()->get(),
             'publishers' => Publisher::latest()->get(),
             'categories' => Category::latest()->get(),
             'book' => $book
         ]);
     }
 
     /**
      * Update the specified resource in storage.
      */
      public function update(UpdateBookRequest $request, $id)
      {
          // Cari data book berdasarkan ID atau kembalikan 404 jika tidak ditemukan
        $book = Book::findOrFail($id);

        // Update field book dari request
        $book->name = $request->input('name');
        $book->auther_id = $request->input('author_id'); // Perbaiki typo jika ada
        $book->category_id = $request->input('category_id');
        $book->publisher_id = $request->input('publisher_id');
        $book->sinopsis = $request->input('sinopsis');

        // Jika ada cover_image baru, hapus gambar lama dan upload gambar baru
        if ($request->hasFile('cover_image')) {
            // Hapus cover image lama jika ada
            if ($book->cover_image && file_exists(public_path($book->cover_image))) {
                unlink(public_path($book->cover_image));
            }

            // Upload cover image baru
            $image = $request->file('cover_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension(); // Nama file unik
            $image->move(public_path('images'), $imageName); // Pindahkan file ke folder public/images
            $book->cover_image = 'images/' . $imageName; // Simpan path baru ke database
        }

        // Simpan perubahan ke database
        $book->save();

        // Redirect dengan pesan sukses
        return redirect()->route('librarian.books')->with('success', 'Book updated successfully.');
      }
      
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy($id)
     {
         $book = Book::findOrFail($id);
 
         // Delete cover image if it exists
         if ($book->cover_image) {
             Storage::disk('public')->delete($book->cover_image);
         }
 
         $book->delete();
 
         return redirect()->route('librarian.books')->with('success', 'Book deleted successfully.');
     }
 }
 
