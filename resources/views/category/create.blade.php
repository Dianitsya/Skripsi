@extends('layouts.app')

@section('content')
    <h1>Tambah Modul</h1>
    <form action="{{ route('module.store') }}" method="POST">
        @csrf
        <label>Nama Modul</label>
        <input type="text" name="name" required>

        <label>Kategori</label>
        <select name="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label>Deskripsi</label>
        <textarea name="description"></textarea>

        <button type="submit">Simpan</button>
    </form>
@endsection
