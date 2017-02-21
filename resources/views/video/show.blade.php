@extends('layouts.app')

@section('content')
<example :user="{{ auth()->user() }}" :video="{{ $video }}">
	
</example>
@endsection
