@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Order #{{ $order->id }}
		</h1>

		<table class="table table-sm table-borderless">
			<tr>
				<th>
					Reference:
				</th>
				<td>
					WEB{{ $order->id }}
				</td>
			</tr>
			<tr>
				<th>
					Status:
				</th>
				<td>
					{{ $order->status }}
				</td>
			</tr>
			<tr>
				<th>
					Date Ordered:
				</th>
				<td>
					{{ \Carbon\Carbon::parse($order->created_at)->format('jS  F Y, g:ia') }}
				</td>
			</tr>
			<tr>
				<th>
					Dispatch By:
				</th>
				<td>

				</td>
			</tr>
			<tr>
				<th>
					Delivery Date:
				</th>
				<td>

				</td>
			</tr>
			<tr>
				<th>
					Payment Method:
				</th>
				<td>
					{{ $order->payment_method_name }}
				</td>
			</tr>
		</table>

        
    </div>
</div>
@endsection