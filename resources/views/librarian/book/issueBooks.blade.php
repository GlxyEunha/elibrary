@extends('librarian.layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">All Borrowed Books</h2>
                </div>
                <div class="offset-md-6 col-md-3">
                    <a class="add-new" href="{{ route('librarian.book_issue.create') }}">Add Borrowed Books</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <th>S.No</th>
                            {{-- <th>Student Name</th> --}}
                            <th>Book Name</th>
                            {{-- <th>Phone</th> --}}
                            {{-- <th>Email</th> --}}
                            <th>Borrowed Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr style='@if (date('Y-m-d') > $book->return_date->format('d-m-Y') && $book->issue_status == 'N') ) background:rgba(255,0,0,0.2) @endif'>
                                    <td>{{ $book->id }}</td>
                                    {{-- <td>{{ $book->student->name }}</td> --}}
                                    <td>{{ $book->book->name }}</td>
                                    {{-- <td>{{ $book->student->phone }}</td> --}}
                                    {{-- <td>{{ $book->student->email }}</td> --}}
                                    <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                    <td>{{ $book->return_date->format('d M, Y') }}</td>
                                    <td>
                                        @if ($book->issue_status == 'Y')
                                            <span class='badge badge-success'>Returned</span>
                                        @else
                                            <span class='badge badge-danger'>Issued</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('librarian.book_issue.edit', $book->id) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <button class="btn btn-danger delete-bookissue" data-id="{{ $book->id }}" data-name="{{ $book->book->name }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">No Books Issued</td>
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
                    <p>Are you sure you want to delete <span id="bookissueName"></span>?</p>
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
            const deleteButtons = document.querySelectorAll('.delete-bookissue'); // Ambil semua tombol delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Modal Bootstrap
            const deleteForm = document.getElementById('deleteForm'); // Formulir penghapusan
            const bookissueNameSpan = document.getElementById('bookissueName'); // Elemen untuk nama penulis
    
            // Tambahkan event listener ke setiap tombol delete
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookissueId = this.getAttribute('data-id'); // Ambil ID penulis
                    const bookissueName = this.getAttribute('data-name'); // Ambil nama penulis
                    const deleteUrl = `{{ url('librarian/book-issue/delete') }}/${bookissueId}`; // URL aksi formulir
    
                    deleteForm.setAttribute('action', deleteUrl); // Setel URL aksi di form
                    bookissueNameSpan.textContent = bookissueName; // Tampilkan nama penulis di modal
                    deleteModal.show(); // Tampilkan modal
                });
            });
        });
    </script>
@endsection
