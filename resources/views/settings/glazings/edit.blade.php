@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
                    
            @if (session('success'))
                <div class="notification is-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <h1 class="title is-3">
                Edit "{{ $glazing->name }}" glazing
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

            <form method="POST" action="{{ route('settings.glazings.update', $glazing->id) }}" autocomplete="off">
                @csrf
                @method('PUT')

                @include('settings.glazings._formFields', ['glazing' => $glazing])
            </form>
                    
            <form id="delete-glazing" action="{{ route('settings.glazings.destroy', [$glazing->id]) }}" method="POST" >
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</div>
<script>
    function deleteGlazing() {
        if (confirm("Are you sure you want to delete this glazing?")) {
            document.getElementById('delete-glazing').submit();
        }
    }
</script>
@endsection