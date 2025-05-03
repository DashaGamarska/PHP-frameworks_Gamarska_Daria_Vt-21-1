
@extends('layouts.app')

@section('content')
<h1>Редагування оцінки</h1>
<form method="POST" action="{{ route('grades.update', $item->id) }}">
    @csrf
    @method('PUT')
    <label>Оцінка:
        <input type="number" step="0.01" name="score" value="{{ $item->score }}" required>
    </label><br>
    <label>ID запису:
        <input type="number" name="enrollment_id" value="{{ $item->enrollment_id }}" required>
    </label><br>
    <button type="submit">Оновити</button>
</form>
@endsection
