
@extends('layouts.app')
@section('content')
<h1>Деталі students</h1>
<p>ID: {{ $item->id }}</p>
<p>Назва: {{ $item->name ?? '—' }}</p>
<a href="{{ route('students.index') }}">← Назад</a>
@endsection
