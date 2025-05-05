
@extends('layouts.app')

@section('content')
<h1>Додати оцінку</h1>
<form method="POST" action="{{ route('grades.store') }}">
    @csrf
    <label>Оцінка:
        <input type="number" step="0.01" name="score" required>
    </label><br>
    <label>ID запису:
        <input type="number" name="enrollment_id" required>
    </label><br>
    <button type="submit">Зберегти</button>
</form>
@endsection
