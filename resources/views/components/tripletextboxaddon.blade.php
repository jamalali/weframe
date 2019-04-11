@isset($label)
	<label class="label">
		{{ $label }}
	</label>
@endisset

<div class="columns is-grouped-triple">
	
	@foreach ($boxes as $box)
	
		@php
			$box_id = $box['id'];
			$value = null;

			if (isset($values[$id])) {
				$value = $values[$id]->$box_id;
			}
		@endphp

		<div class="field column">
			<label class="label @isset($label)
				   is-size-7 has-text-weight-normal
				@else
					is-size-6
				@endisset" for="{{ $id }}[{{ $box['id'] }}]">
				{{ $box['label'] }}
			</label>

			<div class="field has-addons">
				<div class="control">
					<input value="@isset($value){{ $value }}@else{{ old($id.$box['id']) }}@endisset" id="{{ $id }}[{{ $box['id'] }}]" name="{{ $id }}[{{ $box['id'] }}]" class="input" type="text" placeholder="">
				</div>
				<div class="control">
					<span class="button is-static">
						<span class="is-size-7">
							{{ $box['addon'] }}
						</span>
					</span>
				</div>
			</div>
		</div>

	@endforeach

</div>