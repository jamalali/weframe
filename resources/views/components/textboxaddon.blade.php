<div class="field is-horizontal">
	<div class="field-label is-normal">
		<label class="label" for="{{ $id }}">
			{{ $label }}
		</label>
	</div>

	<div class="field-body">
		<div class="field has-addons">
			<div class="control">
				<input value="@isset($settings[$id]){{ $settings[$id] }}@else{{ old($id) }}@endisset" id="{{ $id }}" name="{{ $id }}" class="input" type="text" placeholder="">
			</div>
			<div class="control">
				<span class="button is-static">
					<span class="is-size-7">
						{{ $addon }}
					</span>
				</span>
			</div>
		</div>
	</div>
</div>