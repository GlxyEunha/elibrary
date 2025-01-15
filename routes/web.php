<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AutherController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StudentController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\auth\LoginController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Rute untuk halaman login admin
Route::get('/librarian', function () {
    return view('librarian.welcome');
})->name('librarian.welcome');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute untuk halaman utama (guest user)
// Route::get('/', function () {
//     return view('dashboard'); // Halaman utama untuk guest di file resources/views/dashboard.blade.php
// })->name('guest.dashboard');
Route::get('/guest-dashboard', [BookController::class, 'indexg'])->name('guest.books');
Route::get('/search', [BookController::class, 'search'])->name('guest.search');

// Route::get('/', [CategoryController::class, 'search_category'])->name('search_category');

Route::get('/scanbook', function () {
    return view('librarian.book.scanbook');
})->name('scanbook');

// Scan QR CODE
Route::get('/generate-qrcode/{id}', function ($id) {
    $url = route('librarian.detail', ['id' => $id]); // URL tujuan saat QR code di-scan
    return QrCode::size(300)->generate($url);
});

// Rute untuk user

// Rute untuk user (guest) - melihat daftar buku dan detail buku
Route::get('/student-dashboard', [BookController::class, 'indexg']);
Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');

// Rute untuk meminjam buku (hanya untuk yang sudah login)
// Route::middleware('auth')->group(function () {
//     Route::post('/book/{book}/issue', [BookIssueController::class, 'store'])->name('book.issue');
// });

//AUTH MULTI ROLE
Route::get('/register', [AutherController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AutherController::class, 'register'])->name('register');

Route::get('/login', [AutherController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AutherController::class, 'login'])->name('login');

Route::get('/logout', [AutherController::class, 'logout'])->name('logout');

// Route::middleware('auth')->group(function () {
//     Route::get('/student-dashboard', [AutherController::class, 'studentDashboard'])->name('student.dashboard');
//     Route::get('/librarian-dashboard', [AutherController::class, 'librarianDashboard'])->name('librarian.dashboard');
// });

Route::middleware(['auth', 'role:student'])->group(function () {
    // Route::get('/librarian-dashboard', function () {
    //     return view('librarian.dashboard');
    // })->name('librarian.dashboard');

    // Route::get('/student-dashboard', function () {
    //     return view('dashboard');
    // })->name('student.dashboard');

    Route::get('/student-dashboard', [BookController::class, 'indexg'])->name('student.dashboard');
    Route::get('/student-dashboard/search', [BookController::class, 'search'])->name('student.search');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('librarian.detail');
    Route::post('/book-issue', [BookIssueController::class, 'rent'])->name('rent');
    Route::get('/status', [BookIssueController::class, 'status'])->name('status.user');
});

// Rute untuk login dan logout
// Route::post('/admin', [LoginController::class, 'login'])->name('login');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk user guest - misalnya melihat daftar buku
// Route::get('/books', [BookController::class, 'index'])->name('guest.books');
Route::get('/book/{book}', [BookController::class, 'show'])->name('guest.book.show');

// Rute untuk librarian
Route::prefix('librarian')->middleware(['auth', 'role:librarian'])->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('librarian.dashboard');

    // Ganti Kata Sandi
    Route::get('change-password', [dashboardController::class, 'change_password_view'])->name('librarian.change_password_view');
    Route::post('change-password', [dashboardController::class, 'change_password'])->name('librarian.change_password');

    // CRUD untuk Author
    Route::get('/authors', [AutherController::class, 'index'])->name('librarian.authors');
    Route::get('/authors/create', [AutherController::class, 'create'])->name('librarian.authors.create');
    Route::get('/authors/edit/{auther}', [AutherController::class, 'edit'])->name('librarian.authors.edit');
    Route::post('/authors/update/{id}', [AutherController::class, 'update'])->name('librarian.authors.update');
    Route::post('/authors/delete/{id}', [AutherController::class, 'destroy'])->name('librarian.authors.destroy');
    Route::post('/authors/create', [AutherController::class, 'store'])->name('librarian.authors.store');

    // CRUD untuk Publisher
    Route::get('/publishers', [PublisherController::class, 'index'])->name('librarian.publishers');
    Route::get('/publisher/create', [PublisherController::class, 'create'])->name('librarian.publisher.create');
    Route::get('/publisher/edit/{publisher}', [PublisherController::class, 'edit'])->name('librarian.publisher.edit');
    Route::post('/publisher/update/{id}', [PublisherController::class, 'update'])->name('librarian.publisher.update');
    Route::post('/publisher/delete/{id}', [PublisherController::class, 'destroy'])->name('librarian.publisher.destroy');
    Route::post('/publisher/create', [PublisherController::class, 'store'])->name('librarian.publisher.store');

    // CRUD untuk Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('librarian.categories');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('librarian.category.create');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('librarian.category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('librarian.category.update');
    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('librarian.category.destroy');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('librarian.category.store');

    // CRUD untuk Books
    Route::get('/books', [BookController::class, 'index'])->name('librarian.books');
    Route::get('/book/create', [BookController::class, 'create'])->name('librarian.book.create');
    Route::get('/book/edit/{book}', [BookController::class, 'edit'])->name('librarian.book.edit');
    Route::post('/book/update/{id}', [BookController::class, 'update'])->name('librarian.book.update');
    Route::post('/book/delete/{id}', [BookController::class, 'destroy'])->name('librarian.book.destroy');
    Route::post('/book/create', [BookController::class, 'store'])->name('librarian.book.store');

    // CRUD untuk Students
    Route::get('/students', [StudentController::class, 'index'])->name('librarian.students');
    Route::get('/student/create', [StudentController::class, 'create'])->name('librarian.student.create');
    Route::get('/student/edit/{student}', [StudentController::class, 'edit'])->name('librarian.student.edit');
    Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('librarian.student.update');
    Route::post('/student/delete/{id}', [StudentController::class, 'destroy'])->name('librarian.student.destroy');
    Route::post('/student/create', [StudentController::class, 'store'])->name('librarian.student.store');
    Route::get('/student/show/{id}', [StudentController::class, 'show'])->name('librarian.student.show');

    // CRUD untuk Book Issue
    Route::get('/book_issue', [BookIssueController::class, 'index'])->name('librarian.book_issued');
    Route::get('/book-issue/create', [BookIssueController::class, 'create'])->name('librarian.book_issue.create');
    Route::get('/book-issue/edit/{id}', [BookIssueController::class, 'edit'])->name('librarian.book_issue.edit');
    Route::post('/book-issue/update/{id}', [BookIssueController::class, 'update'])->name('librarian.book_issue.update');
    Route::post('/book-issue/delete/{id}', [BookIssueController::class, 'destroy'])->name('librarian.book_issue.destroy');
    Route::post('/book-issue/create', [BookIssueController::class, 'store'])->name('librarian.book_issue.store');

    // Laporan
    Route::get('/reports', [ReportsController::class, 'index'])->name('librarian.reports');
    Route::get('/reports/Date-Wise', [ReportsController::class, 'date_wise'])->name('librarian.reports.date_wise');
    Route::post('/reports/Date-Wise', [ReportsController::class, 'generate_date_wise_report'])->name('librarian.reports.date_wise_generate');
    Route::get('/reports/monthly-Wise', [ReportsController::class, 'month_wise'])->name('librarian.reports.month_wise');
    Route::post('/reports/monthly-Wise', [ReportsController::class, 'generate_month_wise_report'])->name('librarian.reports.month_wise_generate');
    Route::get('/reports/not-returned', [ReportsController::class, 'not_returned'])->name('librarian.reports.not_returned');

    // Pengaturan
    Route::get('/settings', [SettingsController::class, 'index'])->name('librarian.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('librarian.settings');
});