@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			{{ $customer->name }}
		</h1>
		
		<h4 class="title is-4">
			Orders
		</h4>
		
		@if (count($customer->orders) > 0)
			
			<table class="table is-striped is-fullwidth">
				<thead>
					<tr>
						<th>
							Order no.
						</th>
						<th>
							Date
						</th>
						<th>
							Status
						</th>
						<th>
							Total
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($customer->orders as $order)
						<tr>
							<td>
								{{ $order->id }}
							</td>
							<td>
								{{ \Carbon\Carbon::parse($order->created_at)->format('jS  F Y, G:i:s') }}
							</td>
							<td>
								
							</td>
							<td>
								&pound;{{ $order->total }}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		
		@else
			<p>
				This customer has not placed any orders yet
			</p>
		@endif
		
		<a class="button is-link" href="{{ route('orders.create', ['customer_id' => $customer->id]) }}">
			Create a new order for this customer
		</a>
            
    </div>
</div>
@endsection