@extends('layouts.app')

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
		
		@isset($order->lines)
			<h2 class="title is-4">
				Order items
			</h2>
		
			<table class="table is-striped is-hoverable is-fullwidth">
				<thead>
					<tr>
						<th>
							Description
						</th>
						<th>
							Mould
						</th>
						<th class="has-text-centered">
							Glass size
						</th>
						<th class="has-text-centered">
							Status
						</th>
						<th class="has-text-right">
							Price
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($order->lines as $line)
						<tr>
							<td>
								{{ $line->item_params->artworkDescription }}
							</td>
							<td>
								{{ config('moulds.' . $line->item_params->moulding)['name'] }}
							</td>
							<td class="has-text-centered">
								{{ $line->glass_size }}
							</td>
							<td class="has-text-centered">
								Not started
							</td>
							<td class="has-text-right">
								&pound;{{ $line->total }}
							</td>
							<td class="text-right">
								<a href="{{ route('orders.lines.show', [$order->id, $line->id]) }}">
									view
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<table class="table is-fullwidth">
				<tfoot>
					<tr>
						<td class="has-text-right has-text-weight-bold">
							Total: &pound;{{ $order->total }}
						</td>
					</tr>
				</tfoot>
			</table>
		@endisset

        
    </div>
</div>
@endsection