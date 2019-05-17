<div class="box">
	@horizontaltextinput([
		'label'		=> 'Name',
		'id'		=> 'name',
		'values'	=> $mount
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Width',
		'id'		=> 'width',
		'addon'		=> 'mm',
		'values'	=> $mount
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Height',
		'id'		=> 'height',
		'addon'		=> 'mm',
		'values'	=> $mount
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Price',
		'id'		=> 'price',
		'addon'		=> 'p',
		'values'	=> $mount
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
		'values'	=> $mount
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Height',
		'id'		=> 'oversized_height',
		'addon'		=> 'mm',
		'values'	=> $mount
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Price',
		'id'		=> 'oversized_price',
		'addon'		=> 'p',
		'values'	=> $mount
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
							<option value="white" @if(isset($mount) && $mount->core_colour == 'white')
									selected
									@endif>
								White
							</option>
							<option value="black" @if(isset($mount) && $mount->core_colour == 'black')
									selected
									@endif>
								Black
							</option>
							<option value="multi" @if(isset($mount) && $mount->core_colour == 'multi')
									selected
									@endif>
								Multi
							</option>
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
							<option value="standard" @if(isset($mount) && $mount->thickness == 'standard')
									selected
									@endif>Standard</option>
							<option value="deep" @if(isset($mount) && $mount->thickness == 'deep')
									selected
									@endif>Deep</option>
							<option value="extra_deep" @if(isset($mount) && $mount->thickness == 'extra_deep')
									selected
									@endif>Extra Deep</option>
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

@isset($mount->variants)
	<div class="box">
		<h5 class="title is-5" style="display:inline-block;">
			Variants
		</h5>
		
		<a href="{{ route('admin.mounts.variants.create', $mount->id) }}" class="is-pulled-right">
			Add variant
		</a>
		
		<table class="table is-striped is-hoverable is-fullwidth">
			<thead>
				<tr>
					<th>
						Colour
					</th>
					<th class="has-text-centered">
						SKU
					</th>
					<th class="has-text-centered">
						Inventory
					</th>
					<th class="has-text-centered">
						Price
					</th>
					<th class="has-text-centered">
						Oversized Price
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($mount->variants as $variant)
					<tr>
						<td>
							{{ $variant->colour }}
						</td>
						<td class="has-text-centered">
							{{ $variant->sku }}
						</td>
						<td class="has-text-centered">
							{{ $variant->inventory }}
						</td>
						<td class="has-text-centered">
							{{ $variant->price }}
						</td>
						<td class="has-text-centered">
							{{ $variant->oversized_price }}
						</td>
						<td class="has-text-right">
							<a href="{{ route('admin.mounts.variants.edit', [$mount->id, $variant->id]) }}">
								<i class="fas fa-edit"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endisset

<div>
	@if($type == 'edit')
		<button onclick="deleteMount();" type="button" class="button is-danger">
			Delete mount
		</button>
	@endif
	
	<button class="button is-primary is-pulled-right">
		Save
	</button>
</div>