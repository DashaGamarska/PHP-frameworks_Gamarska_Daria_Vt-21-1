
@extends('layouts.app')

@section('content')
<h1>Список записів</h1>
<a href="{{ route('enrollments.create') }}">+ Додати</a>
<ul>
@foreach ($items as $item)
    <li>ID: {{ $item->id }} — Студент ID: {{ $item->student_id }}, Курс ID: {{ $item->course_id }}
        <a href="{{ route('enrollments.edit', $item->id) }}">Редагувати</a>
        <form action="{{ route('enrollments.destroy', $item->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">Видалити</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
