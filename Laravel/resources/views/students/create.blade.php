
@extends('layouts.app')
@section('content')
<h1>Додати students</h1>
<form method="POST" action="{{ route('students.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Назва" required><br>
    <button type="submit">Зберегти</button>
</form>
@endsection
