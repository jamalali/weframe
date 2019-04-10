<template>
	<div>
		<form id="price-calculator-admin">
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

					<div class="select">
						<select ref="num_apertures" id="num_apertures" v-on:change="getPrice">
							<option value="2">2</option>
							<option value="4">4</option>
							<option value="6">6</option>
							<option value="8">8</option>
						</select>
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

					<div class="select">
						<select ref="top_mount_colour">
							<option value="white">White</option>
							<option value="black">Black</option>
						</select>
					</div>

				</div>

				<div class="column is-one-quarter" v-if="mount == 'double'">

					<h6 class="title is-6" v-if="mount == 'double'">
						Bottom mount colour
					</h6>

					<div class="select">
						<select ref="bottom_mount_colour">
							<option value="white">White</option>
							<option value="black">Black</option>
						</select>
					</div>

				</div>
			</div>

			<hr />

			<div class="columns">
				<div class="field column is-half">
					<label class="label">
						Artwork mounting
					</label>
					<div class="control">
						<div class="select">
							<select ref="artwork_mounting">
								<option>Dry mount</option>
								<option>Japanese hinging tape</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<hr />

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

			<div class="columns">
				<div class="field column is-half">
					<label class="label" for="glazing">
						Glazing
					</label>
					<div class="control">
						<div class="select">
							<select ref="glazing" id="glazing" v-on:change="getPrice">
								<option v-for="glazing in glazings" :value="glazing.id">
									{{ glazing.name }}
								</option>
							</select>
						  </div>
					</div>
				</div>	
			</div>

			<div class="columns">
				<div class="field column is-half">
					<label class="label">
						Fixings
					</label>
					<div class="control">
						<div class="select">
							<select>
								<option selected>Standard</option>
								<option>Heavy</option>
								<option>Invisible</option>
							</select>
						  </div>
					</div>
				</div>	
			</div>

		</form>

		<ul id="example-1">
			<li v-for="(price, key) in prices">
			  {{ key | keyToLabel }}: &pound;{{ price }}
			</li>
		</ul>
	</div>
</template>

<script>
    export default {
		data() {
			return {
				mount: 'none',
				prices: {}
			}
		},
		props: {
			glazings: ''
		},
		computed: {
			topMountColourTitle: function() {
				return this.mount == 'double' ? 'Top mount colour' : 'Mount colour'
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
							colour: this.$refs['top_mount_colour']['value']
						}
					}
					
					if (this.mount == 'double') {
						mount.bottom = {
							size: this.$refs['bottom_mount_size']['value'],
							colour: this.$refs['bottom_mount_colour']['value']
						}
					}
					
					if (this.mount == 'multimount') {
						mount.num_apertures = this.$refs['num_apertures']['value']
						mount.gap_size = this.$refs['gap_size']['value']
						mount.colour = this.$refs['top_mount_colour']['value']
					}
					
					params.mount = mount
					
					// Glass size
					params.glass_size_width = this.$refs['glass_size_width']['value']
					params.glass_size_height = this.$refs['glass_size_height']['value']
					
					// Glazing
					params.glazing = this.$refs['glazing']['value']
					
					//console.log(params)
				
					axios.get('http://weframe.local/api/price', {
						params: params
					})
					.then(response => (
						this.prices = response.data
					))
				})
			}
		}
    }
</script>
