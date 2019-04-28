<template>
	<div>
		<form id="price-calculator-admin">
			<div class="field">

				<label class="label">
					Glass size
				</label>

				<div class="columns">

					<div class="field column is-one-quarter">
						<label class="label is-size-7 has-text-weight-normal" for="glass_size_width">
							Width (mm)
						</label>

						<div class="field">
							<div class="control">
								<input ref="glass_size_width" v-on:keyup="getPrice" id="glass_size_width" class="input" type="text">
							</div>
						</div>
					</div>

					<div class="field column is-one-quarter">
						<label class="label is-size-7 has-text-weight-normal" for="glass_size_height">
							Height (mm)
						</label>

						<div class="field">
							<div class="control">
								<input ref="glass_size_height" v-on:keyup="getPrice" id="glass_size_height" class="input" type="text">
							</div>
						</div>
					</div>

				</div>
			</div>
			
			<hr />
			
			<div class="columns is-multiline">
				<div class="field column is-one-third is-one-fifth-desktop">
					<label class="label">
						Job type
					</label>
					<div class="control">
						<ul>
							<li>
								<label class="radio">
									<input type="radio" value="walk_in" v-on:change="getPrice" v-model="job_type" checked>
									Walk-in
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="contract" v-on:change="getPrice" v-model="job_type">
									Contract
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="online" v-on:change="getPrice" v-model="job_type">
									Online
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="field column is-one-third is-one-fifth-desktop">
					<label class="label">
						Artwork Supplied?
					</label>
					<div class="control">
						<ul>
							<li>
								<label class="radio">
									<input type="radio" value="0" v-on:change="getPrice" v-model="artwork_supplied" checked>
									No
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="1" v-on:change="getPrice" v-model="artwork_supplied">
									Yes
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="field column is-one-third is-one-fifth-desktop">
					<label class="label">
						Box Frame?
					</label>
					<div class="control">
						<ul>
							<li>
								<label class="radio">
									<input type="radio" value="0" v-on:change="getPrice" v-model="box_frame" checked>
									No
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="1" v-on:change="getPrice" v-model="box_frame">
									Yes
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="field column is-one-third is-one-fifth-desktop">
					<label class="label">
						Hinge Mount?
					</label>
					<div class="control">
						<ul>
							<li>
								<label class="radio">
									<input type="radio" value="0" v-on:change="getPrice" v-model="hinge_mount" checked>
									No
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="1" v-on:change="getPrice" v-model="hinge_mount">
									Yes
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="field column is-one-third is-one-fifth-desktop">
					<label class="label">
						Picture Stand?
					</label>
					<div class="control">
						<ul>
							<li>
								<label class="radio">
									<input type="radio" value="0" v-on:change="getPrice" v-model="picture_stand" checked>
									No
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="1" v-on:change="getPrice" v-model="picture_stand">
									Yes
								</label>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<hr />
			
			<div class="columns">
				<div class="field column">
					<label class="label" for="mould_cost">
						Mould cost (£ per metre)
					</label>
					<div class="control">
						<input ref="mould_cost" v-on:keyup="getPrice" id="mould_cost" class="input" type="text">
					</div>
				</div>

				<div class="field column">
					<label class="label" for="mould_width">
						Mould width (mm)
					</label>
					<div class="control">
						<input ref="mould_width" v-on:keyup="getPrice" id="mould_width" class="input" type="text">
					</div>
				</div>
			</div>

			<hr />

			<div class="columns">
				<div class="field column is-half">
					<label class="label">
						Mount
					</label>
					<div class="control">
						<ul class="mount-options">
							<li>
								<label class="radio">
									<input type="radio" value="none" v-on:change="getPrice" v-model="mount" :checked="mount=='none'">
									None
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="single" v-on:change="getPrice" v-model="mount">
									Single
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="double" v-on:change="getPrice" v-model="mount">
									Double
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="circular" v-on:change="getPrice" v-model="mount">
									Circular
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="oval" v-on:change="getPrice" v-model="mount">
									Oval
								</label>
							</li>
							<li>
								<label class="radio">
									<input type="radio" value="multimount" v-on:change="getPrice" v-model="mount">
									Multimount
								</label>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column is-half" v-if="mount == 'single' || mount == 'double' || mount == 'circular' || mount == 'oval'">

					<h6 class="title is-6">
						{{ topMountSizeTitle }}
					</h6>

					<ul class="mount-sizes">
						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_top">
								Top (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_top" v-on:keyup="getPrice" id="top_mount_size_top" class="input" type="text">
								</div>
							</div>
						</li>

						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_bottom">
								Bottom (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_bottom" v-on:keyup="getPrice" id="top_mount_size_bottom" class="input" type="text">
								</div>
							</div>
						</li>

						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_right">
								Right (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_right" v-on:keyup="getPrice" id="top_mount_size_right" class="input" type="text">
								</div>
							</div>
						</li>

						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_left">
								Left (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_left" v-on:keyup="getPrice" id="top_mount_size_left" class="input" type="text">
								</div>
							</div>
						</li>
					</ul>
				</div>

				<div class="column is-one-quarter" v-if="mount == 'double'">

					<h6 class="title is-6" v-if="mount == 'double'">
						Bottom mount size
					</h6>

					<ul>
						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="bottom_mount_size">
								Size (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="5" ref="bottom_mount_size" v-on:keyup="getPrice" id="bottom_mount_size" class="input" type="text">
								</div>
							</div>
						</li>
					</ul>
				</div>

				<div class="column is-one-quarter" v-if="mount == 'multimount'">
					<label class="label is-6 has-text-weight-semibold" for="num_apertures">
						Number of apertures
					</label>
					
					<div class="control">
						<input value="2" ref="num_apertures" v-on:keyup="getPrice" id="num_apertures" class="input" type="text">
					</div>
				</div>
				<div class="column is-one-quarter" v-if="mount == 'multimount'">
					<label class="label is-6 has-text-weight-semibold" for="gap_size">
						Gap size (mm)
					</label>

					<div class="control">
						<input value="5" ref="gap_size" v-on:keyup="getPrice" id="gap_size" class="input" type="text">
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column is-half" v-if="mount == 'single' || mount == 'double' || mount == 'circular' || mount == 'oval' || mount == 'multimount'">

					<h6 class="title is-6">
						{{ topMountColourTitle }}
					</h6>
					
					<div class="columns is-multiline">
						<div class="column is-half" v-for="(mount, mountsIndex) in mounts" style="margin-bottom:20px;">
							<strong>
								{{ mount.name }}
							</strong>

							<div v-for="(variant, variantsIndex) in mount.variants">
								<label class="radio">
									  <input type="radio" name="top_mount_colour" v-model="top_mount_colour" :value="mount.id + '-' + variant.id" v-on:change="getPrice">
									  {{ variant.colour }}
								</label>
							</div>
						</div>
					</div>

				</div>

				<div class="column is-half" v-if="mount == 'double'">

					<h6 class="title is-6" v-if="mount == 'double'">
						Bottom mount style & colour
					</h6>
					
					<div class="columns is-multiline">
						<div class="column is-half" v-for="mount in mounts" style="margin-bottom:20px;">
							<strong>
								{{ mount.name }}
							</strong>

							<div v-for="variant in mount.variants">
								<label class="radio">
									  <input type="radio" name="bottom_mount_colour" v-model="bottom_mount_colour" :value="mount.id + '-' + variant.id" v-on:change="getPrice">
									  {{ variant.colour }}
								</label>
							</div>
						</div>
					</div>

				</div>
			</div>
			
			<hr />
			
			<label class="checkbox label">
				<input type="checkbox" name="dry_mount_included" value="1" ref="dry_mount_included" v-on:change="getPrice">
				Include a dry mount?
			</label>
			
			<label class="checkbox label">
				<input type="checkbox" name="fixings_included" value="1" ref="fixings_included" v-on:change="getPrice">
				Include fixings?
			</label>

			<hr />

			<div class="columns">
				<div class="field column is-half">
					<label class="label" for="glazing">
						Glazing
					</label>
					<div class="control">
						<div class="select">
							<select ref="glazing" id="glazing" v-on:change="getPrice">
								<option value="0" selected>
									None
								</option>
								<option v-for="glazing in glazings" :value="glazing.id">
									{{ glazing.name }}
								</option>
							</select>
						  </div>
					</div>
				</div>
				<div class="field column is-half">
					<label class="label" for="foam_board">
						Foam Board
					</label>
					<div class="control">
						<div class="select">
							<select ref="foam_board" id="foam_board" v-on:change="getPrice">
								<option value="0" selected>
									None
								</option>
								<option v-for="(board, boardName) in foam_boards" :value="boardName">
									{{ boardName }}
								</option>
							</select>
						  </div>
					</div>
				</div>
			</div>

		</form>
	</div>
</template>

<script>
    export default {
		data() {
			return {
				job_type: 'walk_in',
				artwork_supplied: 0,
				hinge_mount: 0,
				box_frame: 0,
				picture_stand: 0,
				mount: 'none',
				top_mount_colour: this.mounts[0]['id'] + '-' + this.mounts[0].variants[0]['id'],
				bottom_mount_colour: this.mounts[0]['id'] + '-' + this.mounts[0].variants[0]['id']
			}
		},
		props: {
			mounts: '',
			glazings: '',
			foam_boards: ''
		},
		computed: {
			topMountColourTitle: function() {
				return this.mount == 'double' ? 'Top mount style & colour' : 'Mount style & colour'
			},
			topMountSizeTitle: function() {
				return this.mount == 'double' ? 'Top mount size' : 'Mount size'
			}
		},
		methods: {
				
			getPrice: function(event) {
				
				this.$nextTick(function () {
					
					const params = {}
					const mount = {}
					
					// Job type and other options
					params.job_type			= this.job_type
					params.artwork_supplied = this.artwork_supplied
					params.hinge_mount		= this.hinge_mount
					params.box_frame		= this.box_frame
					params.picture_stand	= this.picture_stand
					
					// Mould params
					params.mould_cost = this.$refs['mould_cost']['value']
					params.mould_width = this.$refs['mould_width']['value']
					
					// Mount params
					mount.type = this.mount
					
					if (this.mount != 'none' && this.mount != 'multimount') {
						mount.top = {
							sizes: {
								top: this.$refs['top_mount_size_top']['value'],
								right: this.$refs['top_mount_size_right']['value'],
								bottom: this.$refs['top_mount_size_bottom']['value'],
								left: this.$refs['top_mount_size_left']['value']
							},
							colour: this.top_mount_colour
						}
					}
					
					if (this.mount == 'double') {
						mount.bottom = {
							size: this.$refs['bottom_mount_size']['value'],
							colour: this.bottom_mount_colour
						}
					}
					
					if (this.mount == 'multimount') {
						mount.num_apertures = this.$refs['num_apertures']['value']
						mount.gap_size = this.$refs['gap_size']['value']
						mount.colour = this.top_mount_colour
					}
					
					params.mount = mount
					
					// Glass size
					params.glass_size_width = this.$refs['glass_size_width']['value']
					params.glass_size_height = this.$refs['glass_size_height']['value']
					
					// Glazing
					params.glazing = this.$refs['glazing']['value']
					
					// Foam Board
					params.foam_board = this.$refs['foam_board']['value']
					
					// Dry Mount
					params.dry_mount_included = this.$refs['dry_mount_included']['checked']
					
					// Fixings
					params.fixings_included = this.$refs['fixings_included']['checked']
					
					//console.log(params)
				
					axios.get('http://weframe.local/api/price', {
						params: params
					}).then(response => (
						this.$store.commit('updateCalculation', response.data)
					))
				})
			}
		}
    }
</script>
