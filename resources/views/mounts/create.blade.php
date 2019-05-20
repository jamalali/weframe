@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		@include('mounts._ctaRowTop')
		
		<h1 class="title is-3">
			New mount
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

		<form method="POST" action="{{ route('mounts.store') }}" autocomplete="off">
			@csrf

			@include('mounts._formFields', ['type' => 'create', 'mount' => null])
		</form>
            
    </div>
</div>
@endsection