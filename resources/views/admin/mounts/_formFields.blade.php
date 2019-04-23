<div class="box">
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
</div>

<div class="box">
	<h5 class="title is-5">
		Does this have an oversized/jumbo size?
	</h5>

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
</div>

<div class="box">
	<h5 class="title is-5">
		Attributes
	</h5>
	
	<div class="field is-horizontal">
		<div class="field-label is-normal">
			<label class="label" for="core_colour">
				Core colour
			</label>
		</div>
		
		<div class="field-body">
			<div class="field is-narrow">
				<div class="control">
					<div class="select">
						<select name="core_colour" id="core_colour">
							<option value="white">White</option>
							<option value="black">Black</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="field is-horizontal">
		<div class="field-label is-normal">
			<label class="label" for="thickness">
				Thickness
			</label>
		</div>
		
		<div class="field-body">
			<div class="field is-narrow">
				<div class="control">
					<div class="select">
						<select name="thickness" id="thickness">
							<option value="standard">Standard</option>
							<option value="triple">Triple thick</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@if($type == 'create')
	<div class="box">
		<h5 class="title is-5">
			Variants
		</h5>
		<mount-variants></mount-variants>
	</div>
@endif

<div class="field is-grouped">
	<div class="control">
		<a href="{{ route('admin.mounts.index') }}" class="button">
			Cancel
		</a>
	</div>
	<div class="control">
		<button class="button is-primary">
			@isset($glazing)
				Update
			@else
				Save
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