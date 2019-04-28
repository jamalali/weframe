@extends('layouts.admin')

@section('content')
<h1 class="title is-1">
	New order
</h1>

<div class="columns is-centered">
	<div class="column is-two-thirds">
		<price-calculator-admin v-bind:glazings="{{ $glazings }}" v-bind:mounts="{{ $mounts }}" v-bind:foam_boards="{{ $foam_boards }}"></price-calculator-admin>
    </div>
	<div class="column is-one-third">
		<div class="basket-container">
			<h4 class="title is-4">
				Basket
			</h4>
			<p>
				empty
			</p>
		</div>
		<hr />
		<calculation-display-admin></calculation-display-admin>
    </div>
</div>

<a class="button is-warning" href="/admin/orders">
	Cancel
</a>
@endsection