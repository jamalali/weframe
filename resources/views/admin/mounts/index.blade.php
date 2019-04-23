@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Mounts
		</h1>
		
		@if (session('success'))
			<div class="notification is-success">
				<i class="fas fa-check-circle"></i>
				{{ session()->get('success') }}
			</div>
		@endif
		
		@isset ($mounts)
			<table class="table is-striped is-hoverable is-fullwidth">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th class="has-text-centered">
							Width (mm)
						</th>
						<th class="has-text-centered">
							Height (mm)
						</th>
						<th class="has-text-centered">
							Price
						</th>
						<th class="has-text-centered">
							Has jumbo
						</th>
						<th class="has-text-centered">
							Core colour
						</th>
						<th class="has-text-centered">
							Thickness
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($mounts as $mount)
						<tr>
							<td>
								<a href="{{ route('admin.mounts.edit', $mount->id) }}">
									{{ $mount->name }}
								</a>
							</td>
							<td class="has-text-centered">
								{{ $mount->width }}
							</td>
							<td class="has-text-centered">
								{{ $mount->height }}
							</td>
							<td class="has-text-centered">
								&pound;{{ $mount->getPriceInPounds($mount->price) }}
							</td>
							<td class="has-text-centered">
								@if($mount->hasJumbo())
									<span class="icon has-text-success">
										<i class="fas fa-check"></i>
									</span>
								@else
									<span class="icon has-text-danger">
										<i class="fas fa-times"></i>
									</span>
								@endif
							</td>
							<td class="has-text-centered">
								{{ $mount->core_colour }}
							</td>
							<td class="has-text-centered">
								{{ $mount->thickness }}
							</td>
							<td class="has-text-right">
								<a href="{{ route('admin.mounts.edit', $mount->id) }}">
									<i class="fas fa-edit"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endisset
		
		<a class="button is-primary" href="{{ route('admin.mounts.create') }}">
			Add a new mount
		</a>
            
    </div>
</div>
@endsection