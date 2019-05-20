@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			New glazing option
		</h1>
		
		@if ($errors->any())
			<div class="notification is-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('settings.glazings.store') }}" autocomplete="off">
			@csrf

			@include('settings.glazings._formFields')
		</form>
            
    </div>
</div>
@endsection