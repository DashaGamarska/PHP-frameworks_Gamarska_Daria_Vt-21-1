
@extends('layouts.app')
@section('content')
<h1>Редагування students</h1>
<form method="POST" action="{{ route('students.update', $item->id) }}">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $item->name ?? '' }}" required><br>
    <button type="submit">Оновити</button>
</form>
@endsection
