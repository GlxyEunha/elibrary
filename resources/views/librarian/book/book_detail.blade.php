<script src="https://cdn.tailwindcss.com"></script>
<div class="bg-gray-100 dark:bg-gray-800 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row -mx-4">
            <div class="md:flex-1 px-4">
                <div class="h-auto rounded-lg bg-gray-300 dark:bg-gray-700 mb-4">
                    <img 
                        class="w-full h-auto object-cover rounded-lg" 
                        src="{{ asset($book->cover_image) }}" 
                        alt="Cover of {{ $book->name }}"
                    >
                </div>
            </div>
            <div class="md:flex-1 px-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Product Name</h2>
                <span class="text-gray-600 dark:text-gray-300">{{ $book->name }}</span>
                <div class="flex mb-4">
                    <div class="mr-4">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Category:</span>
                        <span class="text-gray-600 dark:text-gray-300">{{ $book->category->name }}</span>
                    </div>
                    <div>
                        <span class="font-bold text-gray-700 dark:text-gray-300">Availability:</span>
                        @if ($book->status == 'Y')
                        <span class="text-gray-600 dark:text-gray-300">Available</span>
                        @else
                        <span class="text-gray-600 dark:text-gray-300">Issued</span>
                        @endif
                    </div>
                </div>
                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Author:</span>
                    <span class="text-gray-600 dark:text-gray-300">{{ $book->auther->name }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Publisher:</span>
                    <span class="text-gray-600 dark:text-gray-300">{{ $book->publisher->name }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Rental Price:</span>
                    <span class="text-gray-600 dark:text-gray-300">Rp 10.000</span>
                </div>
                <div class="mb-4">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Synopsis:</span>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $book->sinopsis ? $book->sinopsis : 'No synopsis available for this book.' }}
                    </p>
                </div>                
                <form class="space-y-4 md:space-y-6" action="{{ route('rent') }}" method="POST">
                    @csrf
                    <span class="font-bold text-gray-700 dark:text-gray-300">Book ID:</span>
                    <div class="mb-4">
                        <input type="text" name="book_id_disabled" value="{{ $book->id }}" disabled class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <!-- Hidden input untuk mengirim nilai book_id -->
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                    </div>
                <div class="flex -mx-2 mb-4">
                    <div class="w-1/2 px-2">
                        @if(Auth::check())
                            <!-- Jika user login, tombol aktif -->
                            <button type="submit" class="w-full bg-gray-900 dark:bg-gray-600 text-white py-2 px-4 rounded-full font-bold hover:bg-gray-800 dark:hover:bg-gray-700">
                                Rent
                            </button>
                        @else
                            <!-- Jika user belum login, tombol disabled -->
                            <button disabled class="w-full bg-gray-900 dark:bg-gray-600 text-white py-2 px-4 rounded-full font-bold opacity-50 cursor-not-allowed">
                                Rent
                            </button>
                        @endif
                    </div>
                    <div class="w-1/2 px-2">
                        @if(Auth::check())
                        <a href="{{ route('student.dashboard') }}" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-full font-bold hover:bg-gray-300 dark:hover:bg-gray-600 text-center block">
                            Back
                        </a>
                        @else
                        <a href="{{ route('guest.books') }}" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-full font-bold hover:bg-gray-300 dark:hover:bg-gray-600 text-center block">
                            Back
                        </a>
                        @endif
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

