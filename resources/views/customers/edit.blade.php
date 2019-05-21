@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
                    
		@if (session('success'))
			<div class="notification is-success">
				{{ session()->get('success') }}
			</div>
		@endif

		<h1 class="title is-3">
			{{ $mount->name }}
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

		<form method="POST" action="{{ route('customers.update', $mount->id) }}" autocomplete="off">
			@csrf
			@method('PUT')

			@include('customers._formFields', ['type' => 'edit', 'mount' => $mount])
		</form>

		<form id="delete-mount" action="{{ route('customers.destroy', [$mount->id]) }}" method="POST" >
			@csrf
			@method('DELETE')
		</form>
		
	</div>
</div>
<script>
    function deleteMount() {
        if (confirm("Are you sure you want to delete this mount?")) {
            document.getElementById('delete-mount').submit();
        }
    }
</script>
@endsection