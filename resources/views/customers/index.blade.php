@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Customers
		</h1>
		
		@if (session('success'))
			<div class="notification is-success">
				<i class="fas fa-check-circle"></i>
				{{ session()->get('success') }}
			</div>
		@endif
		
		@isset ($customers)
			<table class="table is-striped is-hoverable is-fullwidth">
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($customers as $customer)
						<tr>
							<td>
								<a href="{{ route('customers.show', $customer->id) }}">
									{{ $customer->name }}
								</a>
							</td>
							<td class="has-text-right">
								<a href="{{ route('customers.show', $customer->id) }}">
									<i class="fas fa-edit"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endisset
		
		<a class="button is-primary" href="{{ route('customers.create') }}">
			Add a new customer
		</a>
            
    </div>
</div>
@endsection