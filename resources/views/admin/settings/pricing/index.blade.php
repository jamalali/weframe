@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-3">
			Pricing Settings
		</h1>
		
		@if (session('success'))
			<div class="notification is-success">
				{{ session()->get('success') }}
			</div>
		@endif
		
		<form class="is-horizontal is-2-col" action="{{ route('admin.settings.pricing.store') }}" method="POST">
			@csrf
			
			@horizontaltextinput([
				'label'		=> 'Mould length',
				'id'		=> 'mould_length',
				'addon'		=> 'metres',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Mould cut wastage',
				'id'		=> 'mould_cut_wastage',
				'addon'		=> '%',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Glass wastage',
				'id'		=> 'glass_wastage',
				'addon'		=> '%',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Glass markup',
				'id'		=> 'glass_markup',
				'addon'		=> '%',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Mount board wastage',
				'id'		=> 'mount_board_wastage',
				'addon'		=> '%',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Mount board markup',
				'id'		=> 'mount_board_markup',
				'addon'		=> '%',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			<hr />
			
			@horizontaltextinput([
				'label'		=> 'Flexi & fletcher pins',
				'id'		=> 'flexi_fletcher_pins',
				'addon'		=> 'pence per metre',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Plastic bag',
				'id'		=> 'plastic_bag',
				'addon'		=> 'pence per bag',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'D rings',
				'id'		=> 'd_rings',
				'addon'		=> 'pence per frame',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'ATG tape',
				'id'		=> 'atg_tape',
				'addon'		=> 'pence per metre',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'String',
				'id'		=> 'string',
				'addon'		=> 'pence per metre',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			@horizontaltextinput([
				'label'		=> 'Cassese wedges',
				'id'		=> 'cassese_wedges',
				'addon'		=> 'pence per frame',
				'values'	=> $settings
			])@endhorizontaltextinput
			
			<hr />
			
			<div class="columns">
				<div class="column is-one-quarter">
					<h2 class="title is-5 has-text-info">
						Dry mount tissue
					</h2>
					
					@textboxaddon([
						'label'		=> 'Width',
						'id'		=> 'dry_mount_tissue_width',
						'addon'		=> 'mm',
						'values'	=> $settings
					])@endtextboxaddon
					
					@textboxaddon([
						'label'		=> 'Price per metre',
						'id'		=> 'dry_mount_tissue_price',
						'addon'		=> 'p',
						'values'	=> $settings
					])@endtextboxaddon
				</div>
				<div class="column">
					<h2 class="title is-5 has-text-info">
						Pulp board
					</h2>
					
					@tripletextboxaddon([
						'id'		=> 'pulp_board',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'Width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'Height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'Price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
					
					<div class="columns">
						<div class="column">
							@textboxaddon([
								'label'		=> 'Wastage',
								'id'		=> 'pulp_board_wastage',
								'addon'		=> '%',
								'values'	=> $settings
							])@endtextboxaddon
						</div>
						
						<div class="column">
							@textboxaddon([
								'label'		=> 'Markup',
								'id'		=> 'pulp_board_markup',
								'addon'		=> '%',
								'values'	=> $settings
							])@endtextboxaddon
						</div>
					</div>
				</div>
				<div class="column is-one-quarter">
					<h2 class="title is-5 has-text-info">
						Silicone release paper
					</h2>
					
					@textboxaddon([
						'label'		=> 'Price per frame',
						'id'		=> 'silicone_release_paper_price',
						'addon'		=> 'p',
						'values'	=> $settings
					])@endtextboxaddon
				</div>
			</div>
			
			<hr />
			
			<div class="columns">
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Jumbo mount board',
						'id'		=> 'jumbo_mount_board',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Standard mount board',
						'id'		=> 'standard_mount_board',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
			</div>
			<div class="columns">
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Black core mount board',
						'id'		=> 'black_core_mount_board',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Triple thick mount board',
						'id'		=> 'triple_thick_mount_board',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
			</div>
			
			<hr />
			
			<div class="columns">
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Backing board',
						'id'		=> 'backing_board',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
				<div class="column">
				</div>
			</div>
			
			<hr />
			
			<div class="columns">
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Foam board 5mm',
						'id'		=> 'foam_board_5mm',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Foam board 10mm',
						'id'		=> 'foam_board_10mm',
						'values'	=> $settings,
						'boxes'		=> [
							0 => [
								'label' => 'width',
								'id'	=> 'width',
								'addon' => 'mm'
							],
							1 => [
								'label' => 'height',
								'id'	=> 'height',
								'addon' => 'mm'
							],
							2 => [
								'label' => 'price',
								'id'	=> 'price',
								'addon' => 'p'
							]
						]
					])@endtripletextboxaddon
				</div>
			</div>
			
			<div class="field is-grouped">
				<div class="control">
					<a class="button is-warning" href="{{ route('admin.settings.index') }}">
						Cancel
					</a>
				</div>
				<div class="control">
					<input class="button is-success" type="submit" value="Save">
				</div>
			</div>
			
		</form>
            
    </div>
</div>
@endsection