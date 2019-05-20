@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
	
		<div class="cta-row" style="margin-bottom:20px;">
			<a href="{{ route('mounts.edit', $mount->id) }}">
				<i class="fas fa-chevron-left"></i> {{ $mount->name }}
			</a>
		</div>
		
		@if (session('success'))
			<div class="notification is-success">
				{{ session()->get('success') }}
			</div>
		@endif

		<h1 class="title is-3">
			{{ $variant->colour }}
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

		<form method="POST" action="{{ route('mounts.variants.update', [$mount->id, $variant->id]) }}" autocomplete="off">
			@csrf
			@method('PUT')

			@include('mounts.variants._formFields', ['type' => 'edit', 'mount' => $mount, 'variant' => $variant])
		</form>

		<form id="delete-variant" action="{{ route('mounts.variants.destroy', [$mount->id, $variant->id]) }}" method="POST" >
			@csrf
			@method('DELETE')
		</form>
		
	</div>
</div>
<script>
    function deleteVariant() {
        if (confirm("Are you sure you want to delete this variant?")) {
            document.getElementById('delete-variant').submit();
        }
    }
</script>
@endsection