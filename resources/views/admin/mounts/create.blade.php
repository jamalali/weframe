@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		@include('admin.mounts._ctaRowTop')
		
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

		<form method="POST" action="{{ route('admin.mounts.store') }}" autocomplete="off">
			@csrf

			@include('admin.mounts._formFields', ['type' => 'create', 'mount' => false])
		</form>
            
    </div>
</div>
@endsection