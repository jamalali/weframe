@php
	if (isset($values) && isset($values->$id)) {
		$value = $values->$id;
	} else if (isset($values) && isset($values[$id])) {
		$value = $values[$id];
	}
@endphp

<div class="field is-horizontal">
	<div class="field-label is-normal" @isset($grow_label)
		 style="flex-grow: 2;"
		 @endisset>
		<label class="label" for="{{ $id }}">
			{{ $label }}
		</label>
	</div>
	
	<div class="field-body">
		<div class="field is-narrow @isset($addon)
			 has-addons
			 @endisset">
			<div class="control">
				<input value="@isset($value){{ $value }}@else{{ old($id) }}@endisset" type="text" class="input" name="{{ $id }}" id="{{ $id }}" placeholder="">
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
</div>