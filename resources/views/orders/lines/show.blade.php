@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li>
					<a href="{{ route('index') }}">
						Home
					</a>
				</li>
				<li>
					<a href="{{ route('orders.index') }}">
						Orders
					</a>
				</li>
				<li>
					<a href="{{ route('orders.show', $line->order_id) }}">
						Order #{{ $line->order_id }} overview
					</a>
				</li>
				<li class="is-active">
					<a href="#">
						{{ $artwork_description }}
					</a>
				</li>
			</ul>
		</nav>
		
		<div class="columns">
			
			<div class="column is-one-quarter">
				
				<h1 class="title is-3">
					Order #{{ $line->order_id }}
				</h1>
				
				<aside class="menu">
					<p class="menu-label">
						Order lines
					</p>
					<ul class="menu-list">
						@foreach ($siblings as $sibling)
							<li>
								<a href="{{ route('orders.lines.show', [$line->order_id, $sibling->id]) }}"
								   @if ($line->id == $sibling->id)
									class="is-active"
									@endif>
									{{ $sibling->artwork_description }}
								</a>
							</li>
						@endforeach
					</ul>
				</aside>
				
			</div>
			
			<div class="column is-three-quarters">
				
				<h2 class="title is-4">
					{{ $artwork_description }}
				</h2>
		
				<table class="table is-striped is-fullwidth">

					<tr>
						<th>
							Glass size
						</th>
						<td>
							{{ $line->glass_size }}
						</td>
					</tr>
					<tr>
						<th>
							Moulding
						</th>
						<td>
							{{ $moulding['name'] }}
						</td>
					</tr>
					<tr>
						<th>
							Order type
						</th>
						<td>
							{{ $order_type['label'] }}
						</td>
					</tr>
					
					@isset($glazing)
						<tr>
							<th>
								Glazing
							</th>
							<td>
								{{ $glazing['name'] }}
							</td>
						</tr>
					@endisset

					@foreach($item_params as $paramKey => $paramVal)
						@if($paramVal != 0)
							<tr>
								<th>
									{{ camelToCapitalised($paramKey) }}
								</th>
								<td>
									@if ($paramVal == '1')
										<span class="icon has-text-success">
											<i class="fas fa-check"></i>
										</span>
									@elseif (gettype($paramVal) != 'object')
										{{ camelToCapitalised($paramVal) }}
									@else
										{{ json_encode($paramVal) }}
									@endif
								</td>
							</tr>
						@endif
					@endforeach
				</table>
				
				@if($mountboard)
					<h4 class="subtitle is-5">
						Mountboard
					</h4>

					@switch(str_replace('"', '', $mountboard->type))
						@case('single')
							@include('orders.lines.mountboard.single', ['mountboard' => $mountboard])
							@break

						@case('double')
							@include('orders.lines.mountboard.double', ['mountboard' => $mountboard])
							@break

						@default
							{{ json_encode($mountboard) }}
					@endswitch
				@endif
				
			</div>
			
		</div>
        
    </div>
</div>
@endsection