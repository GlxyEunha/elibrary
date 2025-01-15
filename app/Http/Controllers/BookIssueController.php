<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\book;
use App\Models\auther;
use App\Models\history;
use App\Models\student;
use App\Models\settings;
use App\Models\book_issue;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Storebook_issueRequest;
use App\Http\Requests\Updatebook_issueRequest;

class BookIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('librarian.book.issueBooks', [
            'books' => book_issue::Paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('librarian.book.issueBook_add', [
            'students' => student::latest()->get(),
            'books' => book::where('status', 'Y')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storebook_issueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storebook_issueRequest $request)
    {
        $issue_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime("+" . (settings::latest()->first()->return_days) . " days"));
        $data = book_issue::create($request->validated() + [
            'student_id' => $request->student_id,
            'book_id' => $request->book_id,
            'issue_date' => $issue_date,
            'return_date' => $return_date,
            'issue_status' => 'N',
        ]);
        $data->save();
        $book = book::find($request->book_id);
        $book->status = 'N';
        $book->save();
        history::create([
            'student_id' => $request->student_id,
            'book_id' => $request->book_id,
            'issue_date' => $issue_date,
            'return_date' => $return_date,
            'issue_status' => 'N',
        ]);
        return redirect()->route('librarian.book_issued')->with('success', 'Book issue added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // calculate the total fine  (total days * fine per day)
        $book = book_issue::where('id',$id)->get()->first();
        $first_date = date_create(date('Y-m-d'));
        $last_date = date_create($book->return_date);
        $diff = date_diff($first_date, $last_date);
        $fine = (settings::latest()->first()->fine * $diff->format('%a'));
        return view('librarian.book.issueBook_edit', [
            'book' => $book,
            'fine' => $fine,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatebook_issueRequest  $request
     * @param  \App\Models\book_issue  $book_issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $book = book_issue::find($id);
        $book->issue_status = 'Y';
        $book->return_day = now();
        $book->save();
        $bookk = book::find($book->book_id);
        $bookk->status= 'Y';
        $bookk->save();
        return redirect()->route('librarian.book_issued')->with('success', 'Book issue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book_issue  $book_issue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book_issue::find($id)->delete();
        Book::where('id', $id)->update(['status' => 'Y']);
        return redirect()->route('librarian.book_issued')->with('success', 'Book issue deleted successfully.');
    }

    public function rent(Request $request)
    {
        // Validasi input
        $issue_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime("+" . (settings::latest()->first()->return_days) . " days"));
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);
        if ($book->status !== 'Y') {
            return redirect()->back()->with('error', 'The book is currently unavailable for rent.');
        }
        // dd($request->all());

        // Tambahkan data ke tabel book_issue
        $data = book_issue::create([
            'book_id' => $request->book_id,
            'issue_date' => $issue_date,
            'return_date' => $return_date,
            'issue_status' => 'N',
            'user_id' => auth()->id(),
        ]);
        $data->save();
        history::create([
            'book_id' => $request->book_id,
            'issue_date' => $issue_date,
            'return_date' => $return_date,
            'issue_status' => 'N',
        ]);

        Book::where('id', $request->book_id)->update(['status' => 'N']);

        // Redirect dengan pesan sukses
        return redirect()->route('student.dashboard')->with('success', 'Book issued successfully!');
    }

    public function status()
    {
        $userId = auth()->id();

        // Ambil data book_issue dengan relasi book
        $bookIssues = book_issue::with('book')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($issue) {
                $today = Carbon::today(); // Tanggal saat ini
                $returnDate = Carbon::parse($issue->return_date)->startOfDay(); // Konversi return_date ke awal hari

                if ($today->greaterThan($returnDate) && $issue->issue_status === 'N') {
                    // Hitung jumlah hari keterlambatan
                    $lateDays = $today->diffInDays($returnDate);

                    // Hitung denda hanya berdasarkan jumlah hari terlambat
                    $penalty = 5000 * $lateDays;

                    // Tambahkan denda ke rental_price
                    $issue->rental_price += $penalty;
                }

                return $issue;
            });

        return view('status', compact('bookIssues'));
    }
}
