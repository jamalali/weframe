<table class="table is-striped is-fullwidth">
	<tr>
		<th>
			Type
		</th>
		<td>
			{{ ucfirst($mountboard->type) }}
		</td>
	</tr>
	
	@if ($mountboard->oval_aperture != false)
		<tr>
			<th>
				Oval aperture
			</th>
			<td>
				<span class="icon has-text-success">
					<i class="fas fa-check"></i>
				</span>
			</td>
		</tr>
	@endif
	
	<tr>
		<th>
			Sizes
		</th>
		<td>
			<table class="table is-narrow is-pulled-left is-bordered" style="margin-right:10px;">
				<tr>
					<th colspan="2">
						Top mount
					</th>
				</tr>
				<tr>
					<td>
						Top
					</td>
					<td>
						{{ $mountboard->top->sizes->top }}mm
					</td>
				</tr>
				<tr>
					<td>
						Right
					</td>
					<td>
						{{ $mountboard->top->sizes->right }}mm
					</td>
				</tr>
				<tr>
					<td>
						Bottom
					</td>
					<td>
						{{ $mountboard->top->sizes->bottom }}mm
					</td>
				</tr>
				<tr>
					<td>
						Left
					</td>
					<td>
						{{ $mountboard->top->sizes->left }}mm
					</td>
				</tr>
			</table>
			
			<table class="table is-narrow is-bordered">
				<tr>
					<th colspan="2">
						Bottom mount
					</th>
				</tr>
				<tr>
					<td>
						Top
					</td>
					<td>
						{{ $mountboard->top->sizes->top + $mountboard->bottom->size }}mm
					</td>
				</tr>
				<tr>
					<td>
						Right
					</td>
					<td>
						{{ $mountboard->top->sizes->right + $mountboard->bottom->size }}mm
					</td>
				</tr>
				<tr>
					<td>
						Bottom
					</td>
					<td>
						{{ $mountboard->top->sizes->bottom + $mountboard->bottom->size }}mm
					</td>
				</tr>
				<tr>
					<td>
						Left
					</td>
					<td>
						{{ $mountboard->top->sizes->left + $mountboard->bottom->size }}mm
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<th>
			Colour
		</th>
		<td>
			<table class="table is-narrow is-pulled-left is-bordered" style="margin-right:10px;">
				<tr>
					<th colspan="2">
						Top mount
					</th>
				</tr>
				<tr>
					<td>
						{{ $mountboard->colours['top']->colour }}
					</td>
				</tr>
			</table>
			<table class="table is-narrow is-bordered">
				<tr>
					<th colspan="2">
						Bottom mount
					</th>
				</tr>
				<tr>
					<td>
						{{ $mountboard->colours['bottom']->colour }}
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>