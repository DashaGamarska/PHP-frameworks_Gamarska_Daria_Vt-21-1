@extends('layouts.app')

@section('content')
<h1>Деталі курсу</h1>
<p>Назва: {{ $item->name }}</p>
<p>Опис: {{ $item->description }}</p>
<p>Викладач: {{ $item->teacher->name ?? 'Невідомо' }}</p>
<a href="{{ route('courses.index') }}">← Назад</a>
@endsection