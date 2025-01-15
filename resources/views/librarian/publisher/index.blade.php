@extends('librarian.layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">All Publisher</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('librarian.publisher.create') }}">Add Publisher</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>S.No</th>
                            <th>Publisher Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @forelse ($publishers as $publisher)
                                <tr>
                                    <td>{{ $publisher->id }}</td>
                                    <td>{{ $publisher->name }}</td>
                                    <td class="edit">
                                        <a href="{{ route('librarian.publisher.edit', $publisher) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <button class="btn btn-danger delete-publisher" data-id="{{ $publisher->id }}" data-name="{{ $publisher->name }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No Publisher Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $publishers->links('vendor/pagination/bootstrap-4') }}
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
                    <p>Are you sure you want to delete <span id="publisherName"></span>?</p>
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
            const deleteButtons = document.querySelectorAll('.delete-publisher'); // Ambil semua tombol delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Modal Bootstrap
            const deleteForm = document.getElementById('deleteForm'); // Formulir penghapusan
            const publisherNameSpan = document.getElementById('publisherName'); // Elemen untuk nama penulis
    
            // Tambahkan event listener ke setiap tombol delete
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const publisherId = this.getAttribute('data-id'); // Ambil ID penulis
                    const publisherName = this.getAttribute('data-name'); // Ambil nama penulis
                    const deleteUrl = `{{ url('librarian/publisher/delete') }}/${publisherId}`; // URL aksi formulir
    
                    deleteForm.setAttribute('action', deleteUrl); // Setel URL aksi di form
                    publisherNameSpan.textContent = publisherName; // Tampilkan nama penulis di modal
                    deleteModal.show(); // Tampilkan modal
                });
            });
        });
    </script>
@endsection
