@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto py-10">
  <div class="text-center mb-10">
    <h1 class="text-3xl font-bold mb-4">Pilih Platform Kuis</h1>
    <p class="text-gray-600">Silakan pilih platform kuis untuk mulai kegiatan interaktif.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-center">
    <!-- Quizizz -->
    <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center text-center hover:shadow-lg transition">
      <img src="https://cdn.prod.website-files.com/68355113496452bf05789e95/68480ff9c322e13a2f937a22_Logo_Dark_Primary_Horizontal_MINIMUM.svg"
           alt="Quizizz Logo"
           class="h-20 mb-4">
      <h5 class="text-lg font-semibold">Quizizz</h5>
      <p class="text-gray-500 text-sm mt-2">Platform kuis interaktif dan pembelajaran berbasis game.</p>
      <a href="https://wayground.com/?lng=id"
         target="_blank"
         rel="noopener noreferrer"
         class="mt-4 px-5 py-2 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition">
        Buka Quizizz
      </a>
    </div>

    <!-- Kahoot -->
    <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center text-center hover:shadow-lg transition">
      <img src="https://kahoot.com/files/2020/11/Kahoot-1024-rounded.png"
           alt="Kahoot Logo"
           class="h-16 mb-4">
      <h5 class="text-lg font-semibold">Kahoot</h5>
      <p class="text-gray-500 text-sm mt-2">Buat kuis menyenangkan dan langsung ajak peserta bermain.</p>
      <a href="https://kahoot.com/?utm_name=controller_app&utm_source=controller&utm_campaign=controller_app&utm_medium=link"
         target="_blank"
         rel="noopener noreferrer"
         class="mt-4 px-5 py-2 border border-green-500 text-green-500 rounded-lg hover:bg-green-500 hover:text-white transition">
        Buka Kahoot
      </a>
    </div>
  </div>
</div>
@endsection
