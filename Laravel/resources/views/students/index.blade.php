
@extends('layouts.app')
@section('content')
<h1>Список students</h1>
<a href="{{ route('students.create') }}">+ Додати</a>
<ul>
@foreach ($items as $item)
    <li>{{ $item->id }} - <a href="{{ route('students.edit', $item->id) }}">Редагувати</a> | 
        <form action="{{ route('students.destroy', $item->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">Видалити</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
