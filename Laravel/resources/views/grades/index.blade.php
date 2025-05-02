
@extends('layouts.app')

@section('content')
<h1>Список оцінок</h1>
<a href="{{ route('grades.create') }}">+ Додати</a>
<ul>
@foreach ($items as $item)
    <li>ID: {{ $item->id }} — Оцінка: {{ $item->score }}, Enrollment ID: {{ $item->enrollment_id }}
        <a href="{{ route('grades.edit', $item->id) }}">Редагувати</a>
        <form action="{{ route('grades.destroy', $item->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">Видалити</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
