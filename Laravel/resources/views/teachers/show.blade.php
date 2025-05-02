
@extends('layouts.app')
@section('content')
<h1>Деталі teachers</h1>
<p>ID: {{ $item->id }}</p>
<p>Назва: {{ $item->name ?? '—' }}</p>
<a href="{{ route('teachers.index') }}">← Назад</a>
@endsection
