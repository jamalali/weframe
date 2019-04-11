@horizontaltextinput([
	'label'		=> 'Name',
	'id'		=> 'name',
	'values'	=> $glazing
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Width',
	'id'		=> 'width',
	'addon'		=> 'mm',
	'values'	=> $glazing
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Height',
	'id'		=> 'height',
	'addon'		=> 'mm',
	'values'	=> $glazing
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Price',
	'id'		=> 'price',
	'addon'		=> 'p',
	'values'	=> $glazing
])@endhorizontaltextinput

<div class="field is-horizontal">
	<div class="field-label is-normal"></div>
	<div class="field-body">
		<label class="checkbox">
			<input type="checkbox" name="exclude_online" value="1"
				@if(isset($glazing) && $glazing->exclude_online == 1)
				   checked
				@endif>
			Don't show online
		</label>
	</div>
</div>

<div class="field is-horizontal">
	<div class="field-label is-normal"></div>
	<div class="field-body">
		<h4 class="title is-5">
			Does this have an oversized/jumbo size?
		</h4>
	</div>
</div>

@horizontaltextinput([
	'label'		=> 'Width',
	'id'		=> 'oversized_width',
	'addon'		=> 'mm',
	'values'	=> $glazing
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Height',
	'id'		=> 'oversized_height',
	'addon'		=> 'mm',
	'values'	=> $glazing
])@endhorizontaltextinput

@horizontaltextinput([
	'label'		=> 'Price',
	'id'		=> 'oversized_price',
	'addon'		=> 'p',
	'values'	=> $glazing
])@endhorizontaltextinput

<div class="field is-horizontal">
	<div class="field-label is-normal">
		
	</div>
	
	<div class="field-body">
		<div class="field is-grouped">
			<div class="control">
				<a href="{{ route('admin.settings.glazings.index') }}" class="button">
					Cancel
				</a>
			</div>
			<div class="control">
				<button class="button is-primary">
					@isset($glazing)
						Update
					@else
						Add
					@endisset
				</button>
			</div>
			@isset($glazing)
				<div class="control">
					<button onclick="deleteGlazing();" type="button" class="button is-danger">
						Delete
					</button>
				</div>
			@endisset
		</div>
	</div>
</div>