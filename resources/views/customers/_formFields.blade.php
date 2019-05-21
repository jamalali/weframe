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
						'values'		=> $customer
					])@endtextboxaddon
				</div>
				
				<div class="column is-half">
					@textboxaddon([
						'label'			=> 'Last name',
						'id'			=> 'last_name',
						'values'		=> $customer
					])@endtextboxaddon
				</div>
			</div>

			@textboxaddon([
				'label'			=> 'Email',
				'id'			=> 'email',
				'values'		=> $customer
			])@endtextboxaddon

			@textboxaddon([
				'label'			=> 'Phone number',
				'id'			=> 'phone_number',
				'values'		=> $customer
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
						'values'		=> $customer
					])@endtextboxaddon
				</div>
				<div class="column is-half">
					@textboxaddon([
						'label'			=> 'Last name',
						'id'			=> 'address[last_name]',
						'values'		=> $customer
					])@endtextboxaddon	
				</div>
			</div>

			@textboxaddon([
				'label'			=> 'Company',
				'id'			=> 'address[company]',
				'values'		=> $customer
			])@endtextboxaddon

			@textboxaddon([
				'label'			=> 'Address line 1',
				'id'			=> 'address[address_1]',
				'values'		=> $customer
			])@endtextboxaddon
			
			@textboxaddon([
				'label'			=> 'Address line 2',
				'id'			=> 'address[address_2]',
				'values'		=> $customer
			])@endtextboxaddon
			
			@textboxaddon([
				'label'			=> 'City/Town',
				'id'			=> 'address[town]',
				'values'		=> $customer
			])@endtextboxaddon
			
			@textboxaddon([
				'label'			=> 'County',
				'id'			=> 'address[county]',
				'values'		=> $customer
			])@endtextboxaddon
			
			@textboxaddon([
				'label'			=> 'Postcode',
				'id'			=> 'address[postcode]',
				'values'		=> $customer
			])@endtextboxaddon
			
			@textboxaddon([
				'label'			=> 'Phone number',
				'id'			=> 'address[phone_number]',
				'values'		=> $customer
			])@endtextboxaddon
		</div>
	</div>
	
	<div class="column is-one-third">
		
	</div>
	<div class="column is-two-thirds">
		<a class="button is-warning" href="{{ route('customers.index') }}">
			Cancel
		</a>
		
		@if($type == 'edit')
			<button onclick="deleteCustomer();" type="button" class="button is-danger">
				Delete customer
			</button>
		@endif

		<button class="button is-primary is-pulled-right">
			Save
		</button>
	</div>
	
</div>