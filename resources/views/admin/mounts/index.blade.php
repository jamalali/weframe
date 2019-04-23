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
							Hidden online
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($mounts as $glazing_option)
						<tr>
							<td>
								{{ $glazing_option->name }}
							</td>
							<td class="has-text-centered">
								{{ $glazing_option->width }}
							</td>
							<td class="has-text-centered">
								{{ $glazing_option->height }}
							</td>
							<td class="has-text-centered">
								&pound;{{ $glazing_option->getPriceInPounds($glazing_option->price) }}
							</td>
							<td class="has-text-centered">
								@if($glazing_option->hasJumbo())
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
								@if($glazing_option->exclude_online == 1)
									<span class="icon has-text-success">
										<i class="fas fa-check"></i>
									</span>
								@else
									<span class="icon has-text-danger">
										<i class="fas fa-times"></i>
									</span>
								@endif
							</td>
							<td class="text-right">
								<a href="{{ route('admin.mounts.edit', $glazing_option->id) }}">
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