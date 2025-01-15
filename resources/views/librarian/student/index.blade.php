@extends('librarian.layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="admin-heading">All Students</h2>
                </div>
                <div class="offset-md-6 col-md-2">
                    <a class="add-new" href="{{ route('librarian.student.create') }}">Add Student</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>S.No</th>
                            <th>Student Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td class="id">{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td class="text-capitalize">{{ $student->gender }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td class="view">
                                        <button data-sid="{{ $student->id }}>"
                                            class="btn btn-primary view-btn">View</button>
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('librarian.student.edit', $student) }}>" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <button class="btn btn-danger delete-student" data-id="{{ $student->id }}" data-name="{{ $student->name }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No Students Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $students->links('vendor/pagination/bootstrap-4') }}
                    <div id="modal">
                        <div id="modal-form">
                            <table cellpadding="10px" width="100%">

                            </table>
                            <div id="close-btn">X</div>
                        </div>
                    </div>
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
                    <p>Are you sure you want to delete <span id="studentName"></span>?</p>
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
            const deleteButtons = document.querySelectorAll('.delete-student'); // Ambil semua tombol delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Modal Bootstrap
            const deleteForm = document.getElementById('deleteForm'); // Formulir penghapusan
            const studentNameSpan = document.getElementById('studentName'); // Elemen untuk nama penulis
    
            // Tambahkan event listener ke setiap tombol delete
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const studentId = this.getAttribute('data-id'); // Ambil ID penulis
                    const studentName = this.getAttribute('data-name'); // Ambil nama penulis
                    const deleteUrl = `{{ url('librarian/student/delete') }}/${studentId}`; // URL aksi formulir
    
                    deleteForm.setAttribute('action', deleteUrl); // Setel URL aksi di form
                    studentNameSpan.textContent = studentName; // Tampilkan nama penulis di modal
                    deleteModal.show(); // Tampilkan modal
                });
            });
        });
    </script>
@endsection
