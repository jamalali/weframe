@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-1">
			New order
		</h1>
		
		@section('content')
    <example-component></example-component>
@endsection

		<form class="is-horizontal is-2-col" action="{{ route('admin.orders.store') }}" method="POST">
			@csrf
			
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label" for="mould_cost">
						Mould cost (£ per metre)
					</label>
				</div>

				<div class="field-body">
					<div class="control">
						<input id="mould_cost" name="mould_cost" class="input" type="text" placeholder="">
					</div>
				</div>
			</div>
			
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label" for="mould_width">
						Mould width (mm)
					</label>
				</div>

				<div class="field-body">
					<div class="control">
						<input id="mould_width" name="mould_width" class="input" type="text" placeholder="">
					</div>
				</div>
			</div>
			
			<hr />
			
			<div class="field is-horizontal">
			
				<div class="field-label is-normal">
					<label class="label">
						Glass size
					</label>
				</div>
				
				<div class="field-body columns">
					
					<div class="field column">
						<label class="label is-size-7 has-text-weight-normal" for="glass_size[width]">
							Width
						</label>

						<div class="field">
							<div class="control">
								<input id="glass_size[width]" name="glass_size[width]" class="input" type="text" placeholder="">
							</div>
						</div>
					</div>

					<div class="field column">
						<label class="label is-size-7 has-text-weight-normal" for="glass_size[height]">
							Height
						</label>

						<div class="field">
							<div class="control">
								<input id="glass_size[height]" name="glass_size[height]" class="input" type="text" placeholder="">
							</div>
						</div>
					</div>
					
				</div>
				
			</div>
			
			<hr />
			
			<div class="field is-grouped">
				<div class="control">
					<a class="button is-warning" href="{{ route('admin.orders.index') }}">
						Cancel
					</a>
				</div>
				<div class="control">
					<input class="button is-success" type="submit" value="Create">
				</div>
			</div>
		</form>
            
    </div>
</div>
@endsection