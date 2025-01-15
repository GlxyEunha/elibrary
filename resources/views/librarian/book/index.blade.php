@extends('librarian.layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">All Books</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('librarian.book.create') }}">Add Book</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>S.No</th>
                            <th>Book Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Status</th>
                            <th>QR Code</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td class="id">{{ $book->id }}</td>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->category->name }}</td>
                                    <td>{{ $book->auther->name }}</td>
                                    <td>{{ $book->publisher->name }}</td>
                                    <td>
                                        @if ($book->status == 'Y')
                                            <span class='badge badge-success'>Available</span>
                                        @else
                                            <span class='badge badge-danger'>Issued</span>
                                        @endif
                                    </td>
                                    @if (!empty($book->product_code))
                                        @php
                                            // Generate URL untuk halaman tujuan
                                            $redirectUrl = route('librarian.detail', ['id' => $book->id]);
                                        @endphp
                                        <!-- Simpan URL di dalam barcode -->
                                        <td>{!! DNS2D::getBarcodeHTML($redirectUrl, 'QRCODE') !!}</td>
                                        {{-- <p> p - {{ $book->product_code }}</p> <!-- Tampilkan URL (opsional) --> --}}
                                    @else
                                        <td>Product code is missing.</td>
                                    @endif
                                    <td class="edit">
                                        <a href="{{ route('librarian.book.edit', $book) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <button class="btn btn-danger delete-book" data-id="{{ $book->id }}" data-name="{{ $book->name }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No Books Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $books->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <span id="bookName"></span>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <p>{{ session('success') }}</p>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> --}}
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-book'); // Ambil semua tombol delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Modal Bootstrap
            const deleteForm = document.getElementById('deleteForm'); // Formulir penghapusan
            const bookNameSpan = document.getElementById('bookName'); // Elemen untuk nama penulis
    
            // Tambahkan event listener ke setiap tombol delete
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookId = this.getAttribute('data-id'); // Ambil ID penulis
                    const bookName = this.getAttribute('data-name'); // Ambil nama penulis
                    const deleteUrl = `{{ url('librarian/book/delete') }}/${bookId}`; // URL aksi formulir
    
                    deleteForm.setAttribute('action', deleteUrl); // Setel URL aksi di form
                    bookNameSpan.textContent = bookName; // Tampilkan nama penulis di modal
                    deleteModal.show(); // Tampilkan modal
                });
            });
        });
    </script>
@endsection
