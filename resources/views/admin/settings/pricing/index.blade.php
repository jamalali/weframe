@extends('layouts.admin')

@section('content')
<div class="columns is-centered">
	<div class="column">
		
		<h1 class="title is-1">
			Pricing Settings
		</h1>
		
		@if (session('success'))
			<div class="notification is-success">
				{{ session()->get('success') }}
			</div>
		@endif
		
		<form class="is-horizontal is-2-col" action="{{ route('admin.settings.pricing.store') }}" method="POST">
			@csrf
			
			@textboxaddon([
				'label'		=> 'Mould length',
				'id'		=> 'mould_length',
				'addon'		=> 'metres',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Mould cut wastage',
				'id'		=> 'mould_cut_wastage',
				'addon'		=> '%',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Glass wastage',
				'id'		=> 'glass_wastage',
				'addon'		=> '%',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Glass markup',
				'id'		=> 'glass_markup',
				'addon'		=> '%',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Mount board wastage',
				'id'		=> 'mount_board_wastage',
				'addon'		=> '%',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Mount board markup',
				'id'		=> 'mount_board_markup',
				'addon'		=> '%',
				'settings'	=> $settings
			])@endtextboxaddon
			
			<hr />
			
			@textboxaddon([
				'label'		=> 'Flexi & fletcher pins',
				'id'		=> 'flexi_fletcher_pins',
				'addon'		=> 'pence per metre',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Plastic bag',
				'id'		=> 'plastic_bag',
				'addon'		=> 'pence per bag',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'D rings',
				'id'		=> 'd_rings',
				'addon'		=> 'pence per frame',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'ATG tape',
				'id'		=> 'atg_tape',
				'addon'		=> 'pence per metre',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'String',
				'id'		=> 'string',
				'addon'		=> 'pence per metre',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Cassese wedges',
				'id'		=> 'cassese_wedges',
				'addon'		=> 'pence per frame',
				'settings'	=> $settings
			])@endtextboxaddon
			
			<hr />
			
			@textboxaddon([
				'label'		=> 'Dry mount tissue',
				'id'		=> 'dry_mount_tissue',
				'addon'		=> 'pence per metre',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Pulp board',
				'id'		=> 'pulp_board',
				'addon'		=> 'pence per sheet',
				'settings'	=> $settings
			])@endtextboxaddon
			
			@textboxaddon([
				'label'		=> 'Silicone release paper',
				'id'		=> 'silicone_release_paper',
				'addon'		=> 'pence per metre',
				'settings'	=> $settings
			])@endtextboxaddon
			
			<hr />
			
			<div class="columns">
				<div class="column">
					@tripletextboxaddon([
						'label'		=> 'Jumbo mount board',
						'id'		=> 'jumbo_mount_board',
						'settings'	=> $settings,
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
						'settings'	=> $settings,
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
						'settings'	=> $settings,
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
						'settings'	=> $settings,
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
						'label'		=> 'Standard float glass',
						'id'		=> 'standard_float_glass',
						'settings'	=> $settings,
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
						'label'		=> 'Oversized glass',
						'id'		=> 'oversized_glass',
						'settings'	=> $settings,
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
						'label'		=> 'Mirror glass',
						'id'		=> 'mirror_glass',
						'settings'	=> $settings,
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
						'label'		=> 'Oversized mirror',
						'id'		=> 'oversized_mirror',
						'settings'	=> $settings,
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
						'settings'	=> $settings,
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
						'settings'	=> $settings,
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
						'settings'	=> $settings,
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