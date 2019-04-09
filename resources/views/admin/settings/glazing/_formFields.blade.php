@horizontaltextinput([
	'label'		=> 'Name',
	'id'		=> 'name'
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Width',
	'id'		=> 'width',
	'addon'		=> 'mm'
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Height',
	'id'		=> 'height',
	'addon'		=> 'mm'
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Price',
	'id'		=> 'price',
	'addon'		=> 'p'
])@endhorizontaltextinput

<div class="field is-horizontal">
	<div class="field-label is-normal">
		
	</div>
	
	<div class="field-body">
		<label class="checkbox">
			<input type="checkbox" name="exclude_online">
			Don't show online
		</label>
	</div>
</div>

<div class="field is-horizontal">
	<div class="field-label is-normal">
		
	</div>
	
	<div class="field-body">
		<div class="field is-grouped">
			<div class="control">
				<a href="{{ route('admin.settings.glazing.index') }}" class="button">
					Cancel
				</a>
			</div>
			<div class="control">
				<button class="button is-primary">
					@isset($glazing_option)
						Update
					@else
						Add
					@endisset
				</button>
			</div>
			@isset($glazing_option)
				<div class="control">
					<button onclick="deletePage();" type="button" class="button is-danger">
						Delete
					</button>
				</div>
			@endisset
		</div>
	</div>
</div>