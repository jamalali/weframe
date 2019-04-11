@php
	if (isset($values) && isset($values->$id)) {
		$value = $values->$id;
	} else if (isset($values) && isset($values[$id])) {
		$value = $values[$id];
	}
@endphp

<div class="field">
	<label class="label" for="{{ $id }}">
		{{ $label }}
	</label>
	
	<div class="field @isset($addon)
			 has-addons
			 @endisset">
		<div class="control">
			<input value="@isset($value){{ $value }}@else{{ old($id) }}@endisset" id="{{ $id }}" name="{{ $id }}" class="input" type="text" placeholder="">
		</div>
		@isset($addon)
			<div class="control">
				<span class="button is-static">
					<span class="is-size-7">
						{{ $addon }}
					</span>
				</span>
			</div>
		@endisset
	</div>
</div>