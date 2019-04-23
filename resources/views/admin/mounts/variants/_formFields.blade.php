<div class="box">
	@horizontaltextinput([
		'label'		=> 'Colour',
		'id'		=> 'colour',
		'values'	=> $variant
	])@endhorizontaltextinput
	
	@horizontaltextinput([
		'label'		=> 'SKU',
		'id'		=> 'sku',
		'values'	=> $variant
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Inventory',
		'id'		=> 'inventory',
		'values'	=> $variant
	])@endhorizontaltextinput

	@horizontaltextinput([
		'label'		=> 'Price',
		'id'		=> 'price',
		'values'	=> $variant
	])@endhorizontaltextinput
</div>

<div>
	@if($type == 'edit')
		<button onclick="deleteVariant();" type="button" class="button is-danger">
			Delete variant
		</button>
	@endif
	
	<button class="button is-primary is-pulled-right">
		Save
	</button>
</div>