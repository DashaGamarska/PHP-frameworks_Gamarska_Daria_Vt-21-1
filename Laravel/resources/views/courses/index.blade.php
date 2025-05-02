@extends('layouts.app')

@section('content')
<h1>Список курсів</h1>
<a href="{{ route('courses.create') }}">+ Додати курс</a>
<ul>
    @foreach ($items as $item)
        <li>
            {{ $item->name }} — 
            <a href="{{ route('courses.edit', $item->id) }}">Редагувати</a> |
            <a href="{{ route('courses.show', $item->id) }}">Деталі</a> |
            <form action="{{ route('courses.destroy', $item->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Видалити</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection