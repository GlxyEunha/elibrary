<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\book_issue;
use App\Models\history;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('librarian.report.index');
    }

    public function date_wise()
    {
        return view('librarian.report.dateWise', ['books' => '']);
    }

    public function generate_date_wise_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
        return view('librarian.report.dateWise', [
            'books' => history::where('issue_date', $request->date)->latest()->get()
        ]);
    }

    public function month_wise()
    {
        return view('librarian.report.monthWise', ['books' => '']);
    }

    public function generate_month_wise_report(Request $request)
    {
        $request->validate(['month' => "required|date"]);
        return view('librarian.report.monthWise', [
            'books' => history::where('issue_date', 'LIKE', '%' . $request->month . '%')->latest()->get(),
        ]);
    }

    public function not_returned()
    {
        return view('librarian.report.notReturned',[
            'books' => history::latest()->get()
        ]);
    }
}
