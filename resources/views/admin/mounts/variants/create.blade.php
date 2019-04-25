@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
	
		<div class="cta-row" style="margin-bottom:20px;">
			<a href="{{ route('admin.mounts.edit', $mount->id) }}">
				<i class="fas fa-chevron-left"></i> {{ $mount->name }}
			</a>
		</div>
		
		@if (session('success'))
			<div class="notification is-success">
				{{ session()->get('success') }}
			</div>
		@endif

		<h1 class="title is-3">
			Add variant
		</h1>

		@if ($errors->any())
			<div class="notification is-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>
							<i class="fas fa-exclamation-circle"></i> {{ $error }}
						</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('admin.mounts.variants.store', $mount->id) }}" autocomplete="off">
			@csrf

			@include('admin.mounts.variants._formFields', ['type' => 'create', 'mount' => $mount, 'variant' => $variant])
		</form>
		
	</div>
</div>
@endsection