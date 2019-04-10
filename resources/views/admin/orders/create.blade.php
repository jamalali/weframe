@extends('layouts.admin')

@section('content')
<h1 class="title is-1">
	New order
</h1>

<div class="columns is-centered">
	<div class="column is-three-quarters">
		<price-calculator-admin v-bind:glazings="{{ $glazings }}"></price-calculator-admin>
    </div>
	<div class="column">
		<h4 class="title is-4">
			Basket
		</h4>
    </div>
</div>

<a class="button is-warning" href="/admin/orders">
	Cancel
</a>
@endsection