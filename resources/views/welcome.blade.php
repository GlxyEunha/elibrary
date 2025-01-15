<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-Library</title>

  <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('img/favicon.svg')}}">
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>

<body class="leading-normal tracking-normal" style="font-family: 'Montserrat', sans-serif">

  <nav class="flex items-center justify-between flex-wrap bg-blue-200 p-7 px-20">
    <div class="flex items-center flex-shrink-0 text-black mr-6">
      <img src="{{ asset('img/logo.svg')}}" alt=""
        class="transform transition hover:scale-125 duration-300 ease-in-out" />
      <span class="font-bold tracking-wider text-xl">
        &nbsp E-LIBRARY</span>
    </div>
    <div class="block lg:hidden">
      <button
        class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <title>Menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </button>
    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto text-center">
      <div class="text-md lg:flex-grow">
        <a href="/" class="block mt-4 lg:inline-block lg:mt-0 text-black mr-4">
          Home
        </a>
        <a href="#how" class="block mt-4 lg:inline-block lg:mt-0 text-black mr-4">
          Tata Cara
        </a>
      </div>
      <div>
        <button
          class="text-blue-500 font-medium rounded-md py-3 px-4 border-2 border-white focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
          <a href="{{ route('login.form') }}">Masuk</a>
        </button>
      </div>
    </div>
  </nav>

  <!-- Header -->

  <!--Hero-->
  <div class="pt-24 px-16 bg-blue-200">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
      <!--Left Col-->
      <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left text-gray-800">
        <h1 class="my-4 text-4xl font-bold leading-tight">
          Layanan Perpustakaan Online
        </h1>
        <p class="leading-normal text-1xl mb-8">
            Akses Buku dan Pengetahuan Tanpa Batas, di Mana Saja, Kapan Saja!
        </p>
        <button
          class="mx-auto lg:mx-0 bg-blue-500 text-white font-bold rounded-md my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
          <a href="{{ route('guest.books') }}">Pinjam Sekarang!</a>
        </button>
      </div>
      <!--Right Col-->
      <div class="w-full md:w-3/5 text-center">
        <img class="object-fill mx-36 transform transition hover:scale-110 duration-300 ease-in-out"
          src="{{ asset('img/baca.png')}}" />
      </div>
    </div>
  </div>

  <!-- How -->
  <div id="how" class="container my-20 mx-auto px-4 md:px-12">
    <div class="flex flex-wrap -mx-1 lg:-mx-4">
      <!-- Column -->
      <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/4">
        <!-- Article -->
        <article class="overflow-hidden rounded-lg shadow-lg  text-gray-800">
          <img alt="Tulis"
            class="block h-auto w-full lg:w-28 mx-auto my-10 transform transition hover:scale-125 duration-300 ease-in-out"
            src="{{ asset('img/buku2.jpg')}}" />
          <header class="leading-tight p-2 md:p-4 text-center ">
            <h1 class="text-lg font-bold">1. Pilih Buku</h1>
            <p class="text-grey-darker text-sm py-4">
              Pilih terlebih dahulu buku yang ingin dipinjam.
            </p>
          </header>
        </article>
        <!-- END Article -->
      </div>
      <!-- END Column -->
      <!-- Column -->
      <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/4">
        <!-- Article -->
        <article class="overflow-hidden rounded-lg shadow-lg text-gray-800">
          <img alt="Proses"
            class="block h-auto w-full lg:w-28 mx-auto my-10 transform transition hover:scale-125 duration-300 ease-in-out"
            src="{{ asset('img/scan.jpg')}}" />
          <header class="leading-tight p-2 md:p-4 text-center">
            <h1 class="text-lg font-bold">2. Scan QR Code</h1>
            <p class="text-grey-darker text-sm py-4">
              Lakukan scan QR Code untuk meminjam buku.
            </p>
          </header>
        </article>
        <!-- END Article -->
      </div>
      <!-- END Column -->
      <!-- Column -->
      <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/4">
        <!-- Article -->
        <article class="overflow-hidden rounded-lg shadow-lg  text-gray-800">
          <img alt="Ditindak"
            class="block h-auto w-full lg:w-28 mx-auto my-10 transform transition hover:scale-125 duration-300 ease-in-out"
            src="{{ asset('img/status.jpg')}}" />
          <header class="leading-tight p-2 md:p-4 text-center">
            <h1 class="text-lg font-bold">3. Cek Status</h1>
            <p class="text-grey-darker text-sm py-4">
              Pastikan status buku sudah masuk.
            </p>
          </header>
        </article>
        <!-- END Article -->
      </div>
      <!-- END Column -->
      <!-- Column -->
      <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/4">
        <!-- Article -->
        <article class="overflow-hidden rounded-lg shadow-lg  text-gray-800">
          <img alt="Selesai"
            class="block h-auto w-full lg:w-28 mx-auto my-10 transform transition hover:scale-125 duration-300 ease-in-out"
            src="{{ asset('img/centang.png')}}" />
          <header class="leading-tight p-2 md:p-4 text-center">
            <h1 class="text-lg font-bold">4. Selesai</h1>
            <p class="text-grey-darker text-sm py-4">
              Buku sudah berhasil dipinjam.
            </p>
          </header>
        </article>
        <!-- END Article -->
      </div>
      <!-- END Column -->
    </div>
  </div>
  <!-- Footer -->
  <footer class="text-center font-medium bg-blue-200 py-5">
    © 2025 E-LIBRARY | By
    <a href="" target="_blank">Kiki</a>
  </footer>
  @include('sweetalert::alert')
</body>

</html>