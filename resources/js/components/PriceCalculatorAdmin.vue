<template>
	<div>
		<form id="price-calculator-admin">
			<div class="field is-horizontal">
				<div class="field-label is-normal" style="flex-grow: 2;">
					<label class="label has-text-left" for="artwork_description">
						Artwork description
					</label>
				</div>
				
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input" type="text" ref="artwork_description" id="artwork_description">
						</p>
					</div>
				</div>
			</div>
			
			<hr />
			
			<div class="field">
				<label class="label" for="mould">
					Moulding
				</label>
				<div class="control">
					<div class="select is-multiple">
						<select ref="mould" id="mould" size="5" multiple v-on:change="getPrice">
							<option value="0" selected>
								Choose one
							</option>
							<option v-for="(mould, mouldIndex) in moulds" :value="mouldIndex">
								{{ mould.name }}
							</option>
						</select>
					  </div>
				</div>
			</div>
			
			<hr />
			
			<div>
				<label class="label">
					Job type
				</label>
				<div class="buttons has-addons">
					<button type="button" class="button" v-for="(type, typeKey) in job_types" v-on:click="setJobType(typeKey)" v-bind:class="{'is-info is-selected': job_type==typeKey}">
						{{ type.label }}
					</button>
				</div>
			</div>
			
			<hr />
			
			<div class="field">

				<label class="label">
					Artwork size
				</label>

				<div class="columns">

					<div class="field column is-one-quarter">
						<label class="label is-size-7 has-text-weight-normal" for="artwork_width">
							Width (mm)
						</label>

						<div class="field">
							<div class="control">
								<input ref="artwork_width" v-on:keydown="typingTimeout" id="artwork_width" class="input" type="text">
							</div>
						</div>
					</div>

					<div class="field column is-one-quarter">
						<label class="label is-size-7 has-text-weight-normal" for="artwork_height">
							Height (mm)
						</label>

						<div class="field">
							<div class="control">
								<input ref="artwork_height" v-on:keydown="typingTimeout" id="artwork_height" class="input" type="text">
							</div>
						</div>
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
									<input value="50" ref="top_mount_size_top" v-on:keydown="typingTimeout" id="top_mount_size_top" class="input" type="text">
								</div>
							</div>
						</li>

						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_bottom">
								Bottom (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_bottom" v-on:keydown="typingTimeout" id="top_mount_size_bottom" class="input" type="text">
								</div>
							</div>
						</li>

						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_right">
								Right (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_right" v-on:keydown="typingTimeout" id="top_mount_size_right" class="input" type="text">
								</div>
							</div>
						</li>

						<li class="field">
							<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_left">
								Left (mm)
							</label>

							<div class="field">
								<div class="control">
									<input value="50" ref="top_mount_size_left" v-on:keydown="typingTimeout" id="top_mount_size_left" class="input" type="text">
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
									<input value="5" ref="bottom_mount_size" v-on:keydown="typingTimeout" id="bottom_mount_size" class="input" type="text">
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
						<input value="2" ref="num_apertures" v-on:keydown="typingTimeout" id="num_apertures" class="input" type="text">
					</div>
				</div>
				<div class="column is-one-quarter" v-if="mount == 'multimount'">
					<label class="label is-6 has-text-weight-semibold" for="gap_size">
						Gap size (mm)
					</label>

					<div class="control">
						<input value="5" ref="gap_size" v-on:keydown="typingTimeout" id="gap_size" class="input" type="text">
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
			</div>
			
			<hr />
			
			<div>
				<label class="label">
					Fixing
				</label>
				<div class="buttons has-addons">
					<button type="button" class="button" v-for="(fixingOpt, fixingOptKey) in fixings" v-on:click="setFixingType(fixingOptKey)" v-bind:class="{'is-info is-selected': fixing==fixingOptKey}">
						{{ fixingOpt.name }}
					</button>
				</div>
			</div>
			
			<hr />
			
			<div>
				<label class="label">
					Artwork mounting
				</label>
				<div class="buttons has-addons">
					<button type="button" class="button" v-for="(artworkMounting, artworkMountingKey) in artwork_mountings" v-on:click="setArtworkMounting(artworkMountingKey)" v-bind:class="{'is-info is-selected': artwork_mounting==artworkMountingKey}">
						{{ artworkMounting.name }}
					</button>
				</div>
			</div>
			
			<hr />
			
			<div class="columns is-multiline">
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
			</div>

			<hr />

			<div class="columns">
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
				job_type			: 'walk_in',
				artwork_supplied	: 0,
				box_frame			: 0,
				mount				: 'none',
				fixing				: '0',
				artwork_mounting	: '0',
				
				top_mount_colour		: this.mounts[0]['id'] + '-' + this.mounts[0].variants[0]['id'],
				bottom_mount_colour		: this.mounts[0]['id'] + '-' + this.mounts[0].variants[0]['id']
			}
		},
		props: {
			mounts				: '',
			glazings			: '',
			foam_boards			: '',
			moulds				: '',
			job_types			: '',
			fixings				: '',
			artwork_mountings	: ''
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
			
			setArtworkMounting: function(artworkMountingKey) {
				this.artwork_mounting = artworkMountingKey
				this.getPrice()
			},
			
			setFixingType: function(fixingOptKey) {
				this.fixing = fixingOptKey
				this.getPrice()
			},
			
			setJobType: function(jobTypeKey) {
				this.job_type = jobTypeKey
				this.getPrice()
			},
			
			typingTimeout: function(event) {
				
				if (this.timer) {
					clearTimeout(this.timer);
					this.timer = null;
				}
				this.timer = setTimeout(() => {
					this.getPrice()
				}, 1000);
			},
			
			getPrice: function() {
				
				this.$nextTick(function () {
					
					// Required options - check them
					if (this.$refs['mould']['value'] == 0) {
						alert('Please choose a moulding')
						return false
					}
					
					const params = {}
					const mount = {}
					
					// Job type and other options
					params.job_type				= this.job_type
					params.artwork_supplied		= this.artwork_supplied
					params.box_frame			= this.box_frame
					params.fixing				= this.fixing
					params.artwork_mounting		= this.artwork_mounting
					
					// Mould params
					params.mould = this.$refs['mould']['value']
					
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
					
					// Aerwork size
					params.artwork_width = this.$refs['artwork_width']['value']
					params.artwork_height = this.$refs['artwork_height']['value']
					
					// Glazing
					params.glazing = this.$refs['glazing']['value']
					
					// Foam Board
					params.foam_board = this.$refs['foam_board']['value']
					
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
