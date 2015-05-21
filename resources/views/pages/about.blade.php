@extends('app')
	
@section('content')

<h1>About</h1>

<h3>People I Like:</h3>

<ul>
	@foreach ($people as $person) 
		<li>{{$person}}</li>
	@endforeach
</ul>

	
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa consectetur
	 est quod officia voluptatibus vel ut commodi magni, 
	 recusandae voluptatum quae autem deleniti laudantium nulla architecto sapiente 
	 fugit temporibus explicabo.
	 </p>

@stop
