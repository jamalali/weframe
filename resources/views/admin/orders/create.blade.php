@extends('layouts.admin')

@section('content')
<order-type-selector
	v-bind:order_types="{{ $order_types }}"
></order-type-selector>

<h1 class="title is-3">
	New order
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