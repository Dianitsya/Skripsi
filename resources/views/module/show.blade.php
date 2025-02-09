@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <div class="p-5 bg-white border rounded-lg shadow-lg">
        @isset($fileUrl)
            @if ($isImage ?? false)
                <img src="{{ $fileUrl }}" alt="Materi" class="w-full rounded-lg shadow">
            @elseif ($isPdf ?? false)
                <iframe src="{{ $fileUrl }}" class="w-full h-[500px] border" allowfullscreen></iframe>
            @elseif ($isTextFile ?? false)
                <pre class="p-3 bg-gray-100 rounded">{{ $fileContent ?? '' }}</pre>
            @elseif ($isDoc ?? false || $isPpt ?? false)
                <iframe src="{{ $googleViewerUrl }}" class="w-full h-[500px] border" allowfullscreen></iframe>
            @else
                <p class="text-gray-500">File ini tidak bisa ditampilkan, silakan download.</p>
            @endif
            <div class="mt-4">
                <a href="{{ $fileUrl }}" download class="text-green-500 hover:underline">
                    Download Materi
                </a>
            </div>
        @else
            <p class="text-red-500">File tidak ditemukan.</p>
        @endisset
    </div>
</div>
@endsection
