@extends('layouts.app')

@section('content')
<div class="max-w-3xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h2 class="mb-4 text-2xl font-bold text-center text-gray-800">Kuisioner Minat Belajar Pemrograman</h2>
    <p class="mb-6 text-center text-gray-600">Pilih jawaban yang paling sesuai dengan minat Anda dalam belajar pemrograman.</p>

    <form action="{{ route('questionnaire.store') }}" method="POST">
        @csrf

        @foreach($questionsMinat as $index => $question)
        <div class="p-4 mb-6 bg-gray-100 rounded-lg">
            <p class="mb-2 font-semibold text-gray-700">{{ $index + 1 }}. {{ $question }}</p>
            @foreach($options as $value => $label)
            <div class="flex items-center space-x-3">
                <input type="radio" id="q{{ $index }}_{{ $value }}" name="answers[{{ $index }}]" value="{{ $value }}" required class="w-5 h-5 text-blue-600 border-gray-300 focus:ring focus:ring-blue-200">
                <label for="q{{ $index }}_{{ $value }}" class="text-gray-700">{{ $label }}</label>
            </div>
            @endforeach
        </div>
        @endforeach

        <div class="text-center">
            <button type="submit" class="px-6 py-2 font-semibold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                Lanjut ke Kuisioner Gaya Belajar
            </button>
        </div>
    </form>
</div>
@endsection
