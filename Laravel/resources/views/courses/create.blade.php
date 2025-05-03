@extends('layouts.app')

@section('content')
<h1>Додати курс</h1>
<form method="POST" action="{{ route('courses.store') }}">
    @csrf
    <label>Назва: <input type="text" name="name" required></label><br>
    <label>Опис: <textarea name="description" required></textarea></label><br>
    <label>Викладач:
        <select name="teacher_id" required>
            <option value="">Оберіть викладача</option>
            @foreach (\App\Models\Teacher::all() as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
        </select>
    </label><br>
    <button type="submit">Зберегти</button>
</form>
@endsection