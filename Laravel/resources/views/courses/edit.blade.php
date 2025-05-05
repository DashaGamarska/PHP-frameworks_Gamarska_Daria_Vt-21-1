@extends('layouts.app')

@section('content')
<h1>Редагувати курс</h1>
<form method="POST" action="{{ route('courses.update', $item->id) }}">
    @csrf
    @method('PUT')
    <label>Назва: <input type="text" name="name" value="{{ $item->name }}" required></label><br>
    <label>Опис: <textarea name="description" required>{{ $item->description }}</textarea></label><br>
    <label>Викладач:
        <select name="teacher_id" required>
            @foreach (\App\Models\Teacher::all() as $teacher)
                <option value="{{ $teacher->id }}" {{ $teacher->id == $item->teacher_id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
            @endforeach
        </select>
    </label><br>
    <button type="submit">Оновити</button>
</form>
@endsection