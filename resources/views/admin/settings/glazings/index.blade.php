@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Glazings
		</h1>
		
		@if (session('success'))
			<div class="notification is-success">
				<i class="fas fa-check-circle"></i>
				{{ session()->get('success') }}
			</div>
		@endif
		
		@isset ($glazing_options)
			<table class="table is-striped is-hoverable is-fullwidth">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th>
							Width (mm)
						</th>
						<th>
							Height (mm)
						</th>
						<th>
							Price
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($glazing_options as $glazing_option)
						<tr>
							<td>
								{{ $glazing_option->name }}
							</td>
							<td>
								{{ $glazing_option->width }}
							</td>
							<td>
								{{ $glazing_option->height }}
							</td>
							<td>
								&pound;{{ $glazing_option->getPriceInPounds($glazing_option->price) }}
							</td>
							<td class="text-right">
								<a href="{{ route('admin.settings.glazings.edit', $glazing_option->id) }}">
									<i class="fas fa-edit"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endisset
		
		<a class="button is-primary" href="{{ route('admin.settings.glazings.create') }}">
			Add a new glazing option
		</a>
            
    </div>
</div>
@endsection