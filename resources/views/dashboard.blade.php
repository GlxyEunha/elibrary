<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
@extends('layout.app')
@section('content')
<header class="bg-white shadow">
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
    <div>
      @if(Auth::check())
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">Halo, {{ auth()->user()->name }}</h1>
      @else
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">Halo, Guest</h1>
      @endif
    </div>
    <!-- Search bar -->
    <div class="max-w-sm w-full">
      <form method="GET" action="{{ route('guest.search') }}">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <input type="search" id="default-search" name="q" value="{{ request('q') }}"
                   class="block w-full p-3 pr-16 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                   placeholder="Search Book Title and Author..." required />
            <button type="submit" 
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Search
            </button>
        </div>
    </form>
    </div>
  </div>
</header>
<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      @forelse ($books as $book)
      <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-6 flex flex-col h-full">
        <div class="space-y-2 flex-1">
          @if ($book->cover_image)
            <div class="flex items-center justify-center h-48 overflow-hidden">
              <img src="{{ asset($book->cover_image) }}" alt="Cover of {{ $book->name }}" 
                   class="object-contain max-h-full max-w-full">
            </div>
          @else
            <div class="bg-gray-200 w-full h-48 flex items-center justify-center text-gray-500">
              No Cover Image
            </div>
          @endif
          <h2 class="text-lg font-semibold">{{ $book->name }}</h2>
          <p><strong>Category:</strong> {{ $book->category->name }}</p>
          <p><strong>Author:</strong> {{ $book->auther->name }}</p>
          <p><strong>Publisher:</strong> {{ $book->publisher->name }}</p>
          @if (!empty($book->product_code))
              @php
                  // Generate URL untuk halaman tujuan
                  $redirectUrl = route('librarian.detail', ['id' => $book->id]);
              @endphp
              <!-- Simpan URL di dalam barcode -->
              <div>{!! DNS2D::getBarcodeHTML($redirectUrl, 'QRCODE') !!}</div>
              <p> p - {{ $book->product_code }}</p> <!-- Tampilkan URL (opsional) -->
          @else
              <div>Product code is missing.</div>
          @endif
          {{-- <div class="visible-print text-center"> 
            {!! QrCode::size(100)->generate(''); !!}
            <p>scan this QR</p>
          </div>
          <img src="{{ url('/generate-qrcode/' . $book->id) }}" alt="QR Code"> --}}
        </div>
        <div class="text-right mt-4">
          <span class="px-2 py-1 rounded-md text-white text-sm 
            {{ $book->status == 'Y' ? 'bg-green-500' : 'bg-red-500' }}">
            {{ $book->status == 'Y' ? 'Available' : 'Issued' }}
          </span>
        </div>
      </div>
      @empty
      <div class="text-gray-500 col-span-3">No Books Found</div>
      @endforelse
    </div>
    <div class="mt-6 flex justify-center">
      {{ $books->links('vendor/pagination/bootstrap-4') }}
    </div>
  </div>

  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContent">
            <!-- Isi modal akan dimuat dengan Ajax -->
        </div>
    </div>
</div>
</main>
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header bg-success text-white">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
  window.addEventListener("load", function(event) {
  document.querySelector('[data-dropdown-toggle="dropdown"]').click();
});
</script>
@endsection
