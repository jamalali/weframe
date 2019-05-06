@extends('layouts.admin')

@section('content')
<h1 class="title is-1">
	New order
</h1>

<div class="columns is-centered">
	<div class="column is-two-thirds">
		<price-calculator
			v-bind:glazings="{{ $glazings }}"
			v-bind:mounts="{{ $mounts }}"
			v-bind:foam_boards="{{ $foam_boards }}"
			v-bind:moulds="{{ $moulds }}"
			v-bind:job_types="{{ $job_types }}"
			v-bind:fixings="{{ $fixings }}"
			v-bind:artwork_mountings="{{ $artwork_mountings }}"
		></price-calculator>
    </div>
	<div class="column is-one-third">
		<basket></basket>
		<hr />
		<calculation-display-admin></calculation-display-admin>
    </div>
</div>

<a class="button is-warning" href="/admin/orders">
	Cancel
</a>
@endsection