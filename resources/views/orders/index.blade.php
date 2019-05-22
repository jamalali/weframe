@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-1">
			Orders
		</h1>
		
		@isset ($orders)
			<table class="table table-striped is-fullwidth">

				<thead class="thead-light">
					<tr>
						<th>
							Order
						</th>
						<th>
							Date
						</th>
						<th>
							Customer
						</th>
						<th>
							Payment
						</th>
						<th>
							Order Total
						</th>
						
						<th>
							Courier
						</th>
						<th>
							Status
						</th>
						<th>
						</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($orders as $order)
						<tr>
							<td>
								<a href="{{ route('orders.show', $order->id) }}">
									#WEB{{ $order->id }}
								</a>
							</td>
							<td>
								{{ \Carbon\Carbon::parse($order->created_at)->format('j F \a\t G:i') }}
							</td>
							<td>
								@if ($order->customer)
									{{ $order->customer->name }}
								@endif
							</td>
							<td>
								{{ $order->payment_method_name }}
							</td>
							<td>
								&pound;{{ $order->total }}
							</td>
							<td>
								n/a
							</td>
							<td>
								{{ $order->status }}
							</td>
							<td class="text-right">
								<a href="{{ route('orders.show', $order->id) }}">
									view
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>

			</table>
		@endisset

		<div class="tile is-ancestor">
			<div class="tile is-2 is-parent">
				<div class="tile is-child">
					<a class="title is-5 box has-text-centered" href="{{ route('orders.create') }}">
						Create an order
					</a>
				</div>
			</div>
		</div>
            
    </div>
</div>
@endsection