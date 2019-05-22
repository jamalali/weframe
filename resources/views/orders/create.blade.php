@extends('layouts.app')

@section('content')
@if($customer != false)
	<div class="cta-row" style="margin-bottom:20px;">
		<a href="{{ route('customers.show', $customer->id) }}">
			<i class="fas fa-chevron-left"></i> Back to {{ $customer->name }}
		</a>
	</div>
@endisset

<order-type-selector
	v-bind:order_types="{{ $order_types }}"
></order-type-selector>

<basket-items-viewer
	v-bind:moulds="{{ $moulds }}"
></basket-items-viewer>

<h1 class="title is-3">
	New order @if($customer != false) for {{ $customer->name}}@endif
</h1>

<div class="columns is-centered">
	<div class="column is-two-thirds">
		<price-calculator
			v-bind:glazings="{{ $glazings }}"
			v-bind:mounts="{{ $mounts }}"
			v-bind:foam_boards="{{ $foam_boards }}"
			v-bind:moulds="{{ $moulds }}"
			v-bind:fixings="{{ $fixings }}"
			v-bind:artwork_mountings="{{ $artwork_mountings }}"
			
			@if($customer != false)
				v-bind:customer_id="{{ $customer->id }}"
			@endif
		></price-calculator>
    </div>
	<div class="column is-one-third">
		<basket></basket>
		<hr />
		<order-item-breakdown></order-item-breakdown>
    </div>
</div>

<a class="button is-warning" href="/admin/orders">
	Cancel
</a>
@endsection