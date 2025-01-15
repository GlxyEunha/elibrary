<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
@extends('layout.app')
@section('content')
<header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @if(Auth::check())
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Halo, {{ auth()->user()->name }}</h1>
        @else
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Halo, Guest</h1>
        @endif
    </div>
</header>
<main>
    <div class="relative overflow-x-auto">
        @if($bookIssues->isEmpty())
            <p class="text-gray-500">Belum ada buku yang dipinjam.</p>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Book Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Issue Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Return Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Rental Price
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookIssues as $issue)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $issue->book->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $issue->issue_date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $issue->return_date }}
                    </td>
                    <td class="px-6 py-4">
                        @if($issue->issue_status === 'N')
                            <span class="text-yellow-500 font-bold">Not Returned</span>
                        @else
                            <span class="text-green-500 font-bold">Returned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        Rp {{ number_format($issue->rental_price, 0, ',', '.') }}
                        @if (Carbon\Carbon::today()->greaterThan(Carbon\Carbon::parse($issue->return_date)) && $issue->issue_status === 'N')
                            <span class="text-red-500 text-sm">(Late Fee Applied)</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</main>
@endsection