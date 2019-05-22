@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Add customer
		</h1>
		
		@if ($errors->any())
			<div class="notification is-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('customers.store') }}" autocomplete="off">
			@csrf
			
			<input type="hidden" name="address[is_default]" value="1">

			<div class="columns is-multiline">
	
				<div class="column is-one-third">
					<h5 class="title is-5">
						Customer overview
					</h4>
				</div>
				<div class="column is-two-thirds">
					<div class="box">

						<div class="columns">
							<div class="column is-half">
								@textboxaddon([
									'label'			=> 'First name',
									'id'			=> 'first_name',
								])@endtextboxaddon
							</div>

							<div class="column is-half">
								@textboxaddon([
									'label'			=> 'Last name',
									'id'			=> 'last_name'
								])@endtextboxaddon
							</div>
						</div>

						@textboxaddon([
							'label'			=> 'Email',
							'id'			=> 'email'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'Phone number',
							'id'			=> 'phone_number'
						])@endtextboxaddon

						<div class="field">
							<div class="control">
								<label class="checkbox">
									<input type="checkbox" name="accepts_marketing" value="1">
									Customer accepts marketing
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="column is-one-third">
					<h5 class="title is-5">
						Address
					</h4>
				</div>
				<div class="column is-two-thirds">
					<div class="box">

						<div class="columns">
							<div class="column is-half">
								@textboxaddon([
									'label'			=> 'First name',
									'id'			=> 'address[first_name]',
									'old'			=> 'address.first_name'
								])@endtextboxaddon
							</div>
							<div class="column is-half">
								@textboxaddon([
									'label'			=> 'Last name',
									'id'			=> 'address[last_name]',
									'old'			=> 'address.last_name'
								])@endtextboxaddon	
							</div>
						</div>

						@textboxaddon([
							'label'			=> 'Company',
							'id'			=> 'address[company]',
							'old'			=> 'address.company'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'Address line 1',
							'id'			=> 'address[address_1]',
							'old'			=> 'address.address_1'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'Address line 2',
							'id'			=> 'address[address_2]',
							'old'			=> 'address.address_2'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'City/Town',
							'id'			=> 'address[town]',
							'old'			=> 'address.town'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'County',
							'id'			=> 'address[county]',
							'old'			=> 'address.county'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'Postcode',
							'id'			=> 'address[postcode]',
							'old'			=> 'address.postcode'
						])@endtextboxaddon

						@textboxaddon([
							'label'			=> 'Phone number',
							'id'			=> 'address[phone_number]',
							'old'			=> 'address.phone_number'
						])@endtextboxaddon
					</div>
				</div>

				<div class="column is-one-third">

				</div>
				<div class="column is-two-thirds">
					<a class="button is-warning" href="{{ route('customers.index') }}">
						Cancel
					</a>

					<button class="button is-primary is-pulled-right">
						Save
					</button>
				</div>

			</div>
		</form>
            
    </div>
</div>
@endsection