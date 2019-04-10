@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-1">
			Settings
		</h1>

		<div class="tile is-ancestor">
			<div class="tile is-2 is-parent">
				<div class="tile is-child">
					<a class="title is-5 box has-text-centered" href="{{ route('admin.settings.pricing.index') }}">
						Pricing
					</a>
				</div>
			</div>
			
			<div class="tile is-2 is-parent">
				<div class="tile is-child">
					<a class="title is-5 box has-text-centered" href="{{ route('admin.settings.glazings.index') }}">
						Glazings
					</a>
				</div>
			</div>
		</div>
            
    </div>
</div>
@endsection