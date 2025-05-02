
@extends('layouts.app')
@section('content')
<h1>Список teachers</h1>
<a href="{{ route('teachers.create') }}">+ Додати</a>
<ul>
@foreach ($items as $item)
    <li>{{ $item->id }} - <a href="{{ route('teachers.edit', $item->id) }}">Редагувати</a> | 
        <form action="{{ route('teachers.destroy', $item->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">Видалити</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
