@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Add customer
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

		<form method="POST" action="{{ route('customers.store') }}" autocomplete="off">
			@csrf

			@include('customers._formFields', ['type' => 'create', 'customer' => null])
		</form>
            
    </div>
</div>
@endsection