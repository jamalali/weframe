@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-1">
			Orders
		</h1>
		
		@isset ($orders)
			<table class="table table-striped">

				<thead class="thead-light">
					<tr>
						<th>
							Reference
						</th>
						<th>
							Billing Name
						</th>
						<th>
							Payment Method
						</th>
						<th>
							Order Total
						</th>
						<th>
							Date Ordered
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
								<a href="{{ route('admin.orders.show', $order->id) }}">
									WEB{{ $order->id }}
								</a>
							</td>
							<td>
								@if ($order->customer)
									{{ $order->customer->firstname }} {{ $order->customer->surname }}
								@endif
							</td>
							<td>
								{{ $order->payment_method_name }}
							</td>
							<td>
								&pound;{{ $order->total }}
							</td>
							<td>
								{{ \Carbon\Carbon::parse($order->created_at)->format('jS  F Y, G:i:s') }}
							</td>
							<td>
								n/a
							</td>
							<td>
								{{ $order->status }}
							</td>
							<td class="text-right">
								<a href="{{ route('admin.orders.show', $order->id) }}">
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
					<a class="title is-5 box has-text-centered" href="{{ route('admin.orders.create') }}">
						Create an order
					</a>
				</div>
			</div>
		</div>
            
    </div>
</div>
@endsection