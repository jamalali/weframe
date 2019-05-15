<template>
	<div id="mount-selector">
		<div class="columns">
			<div class="field column">
				<label class="label">
					Mount
				</label>
				<div class="buttons has-addons">
					<button class="button" v-on:click.prevent="setMountType('none')" v-bind:class="{'is-info is-selected': mountType=='none'}">
						None
					</button>
					<button class="button" v-on:click.prevent="setMountType('single')" v-bind:class="{'is-info is-selected': mountType=='single'}">
						Single
					</button>
					<button class="button" v-on:click.prevent="setMountType('double')" v-bind:class="{'is-info is-selected': mountType=='double'}">
						Double
					</button>
				</div>
			</div>
		</div>
		<div class="columns is-multiline" v-if="mountType == 'single' || mountType == 'double'">
			<div class="column is-full">
				<ul class="is-horizontal">
					<li>
						<label class="checkbox">
							<input type="checkbox" v-model="equal_mount_borders" :checked="equal_mount_borders">
							Equal borders
						</label>
					</li>
					<li>
						<label class="checkbox">
							<input type="checkbox" v-model="oval_aperture" :checked="oval_aperture" v-on:change="returnMount">
							Oval/circular aperture
						</label>
					</li>
				</ul>
			</div>
			<div class="column is-half">
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
								<input v-model="top_mount_size_top" v-on:keydown="topMountDimensions('top', $event)" id="top_mount_size_top" class="input" type="text">
							</div>
						</div>
					</li>

					<li class="field">
						<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_bottom">
							Bottom (mm)
						</label>

						<div class="field">
							<div class="control">
								<input v-model="top_mount_size_bottom" v-on:keydown="topMountDimensions('bottom', $event)" id="top_mount_size_bottom" class="input" type="text">
							</div>
						</div>
					</li>

					<li class="field">
						<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_right">
							Right (mm)
						</label>

						<div class="field">
							<div class="control">
								<input v-model="top_mount_size_right" v-on:keydown="topMountDimensions('right', $event)" id="top_mount_size_right" class="input" type="text">
							</div>
						</div>
					</li>

					<li class="field">
						<label class="label is-size-7 has-text-weight-normal" for="top_mount_size_left">
							Left (mm)
						</label>

						<div class="field">
							<div class="control">
								<input v-model="top_mount_size_left" v-on:keydown="topMountDimensions('left', $event)" id="top_mount_size_left" class="input" type="text">
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="column is-one-quarter" v-if="mountType == 'double'">
				<h6 class="title is-6" v-if="mountType == 'double'">
					Bottom mount size
				</h6>
				<ul>
					<li class="field">
						<label class="label is-size-7 has-text-weight-normal" for="bottom_mount_size">
							Size (mm)
						</label>

						<div class="field">
							<div class="control">
								<input v-model="bottom_mount_size" v-on:keydown="typingTimeout" id="bottom_mount_size" class="input" type="text">
							</div>
						</div>
					</li>
				</ul>
			</div>
<!--			<div class="column is-one-quarter" v-if="mountType == 'multimount'">
				<label class="label is-6 has-text-weight-semibold" for="num_apertures">
					Number of apertures
				</label>

				<div class="control">
					<input value="2" ref="num_apertures" v-on:keydown="typingTimeout" id="num_apertures" class="input" type="text">
				</div>
			</div>-->
<!--			<div class="column is-one-quarter" v-if="mountType == 'multimount'">
				<label class="label is-6 has-text-weight-semibold" for="gap_size">
					Gap size (mm)
				</label>

				<div class="control">
					<input value="5" ref="gap_size" v-on:keydown="typingTimeout" id="gap_size" class="input" type="text">
				</div>
			</div>-->
		</div>
		<div class="columns">
			<div class="column is-half" v-if="mountType == 'single' || mountType == 'double'">

				<h6 class="title is-6">
					{{ topMountColourTitle }}
				</h6>

				<div class="columns is-multiline">
					<div class="column is-half" v-for="mountVal in mounts" style="margin-bottom:20px;">
						<strong>
							{{ mountVal.name }}
						</strong>

						<div v-for="(variant, variantsIndex) in mountVal.variants">
							<label class="radio">
								  <input type="radio" name="top_mount_colour" v-model="top_mount_colour" :value="mountVal.id + '-' + variant.id" v-on:change="returnMount">
								  {{ variant.colour }}
							</label>
						</div>
					</div>
				</div>

			</div>

			<div class="column is-half" v-if="mountType == 'double'">

				<h6 class="title is-6" v-if="mountType == 'double'">
					Bottom mount style & colour
				</h6>

				<div class="columns is-multiline">
					<div class="column is-half" v-for="mountVal in mounts" style="margin-bottom:20px;">
						<strong>
							{{ mountVal.name }}
						</strong>

						<div v-for="variant in mountVal.variants">
							<label class="radio">
								  <input type="radio" name="bottom_mount_colour" v-model="bottom_mount_colour" :value="mountVal.id + '-' + variant.id" v-on:change="returnMount">
								  {{ variant.colour }}
							</label>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>
<script>
	function dataDefaults(mounts) {
		return {
			mountType			: 'none',
			equal_mount_borders	: true,
			oval_aperture		: false,

			top_mount_size_top		: 50,
			top_mount_size_right	: 50,
			top_mount_size_bottom	: 50,
			top_mount_size_left		: 50,

			bottom_mount_size : 5,

			top_mount_colour		: mounts[0]['id'] + '-' + mounts[0].variants[0]['id'],
			bottom_mount_colour		: mounts[0]['id'] + '-' + mounts[0].variants[0]['id']
		}
	}
	
    export default {
		data() {
			return dataDefaults(this.mounts)
		},
		props: {
			mounts: '',
			mount: {}
		},
		watch: {
			mount: function(newMount) {
				if (newMount.type == 'none') {
					Object.assign(this.$data, dataDefaults(this.mounts))
				}
			}
		},
		computed: {
			topMountColourTitle: function() {
				return this.mountType == 'double' ? 'Top mount style & colour' : 'Mount style & colour'
			},
			topMountSizeTitle: function() {
				return this.mountType == 'double' ? 'Top mount size' : 'Mount size'
			}
		},
		methods: {
			setMountType: function(type) {
				this.mountType = type
				this.returnMount()
			},
			
			topMountDimensions: function(position, event) {
				
				if (this.timer) {
					clearTimeout(this.timer);
					this.timer = null;
				}

				this.timer = setTimeout(() => {

					let value = event.target.value

					if (value.length > 0) {

						if (this.equal_mount_borders) {
							if (position !== 'top')		{ this.top_mount_size_top = value }
							if (position !== 'right')	{ this.top_mount_size_right = value }
							if (position !== 'bottom')	{ this.top_mount_size_bottom = value }
							if (position !== 'left')	{ this.top_mount_size_left = value }
						}

						this.returnMount()
					}
				}, 500);
			},
			
			typingTimeout: function(event) {
				
				if (this.timer) {
					clearTimeout(this.timer);
					this.timer = null;
				}
				this.timer = setTimeout(() => {
					this.returnMount()
				}, 1000);
			},
			
			returnMount: function() {
				
				this.$nextTick(function () {
					
					const newMount = {}
					
					// Mount params
					newMount.type = this.mountType
					newMount.oval_aperture = this.oval_aperture
					
					if (this.mountType != 'none') {
						newMount.top = {
							sizes: {
								top		: this.top_mount_size_top,
								right	: this.top_mount_size_right,
								bottom	: this.top_mount_size_bottom,
								left	: this.top_mount_size_left
							},
							colour: this.top_mount_colour
						}
					}
					
					if (this.mountType == 'double') {
						newMount.bottom = {
							size	: this.bottom_mount_size,
							colour	: this.bottom_mount_colour
						}
					}
					
//					if (this.mountType == 'multimount') {
//						newMount.num_apertures = this.$refs['num_apertures']['value']
//						newMount.gap_size = this.$refs['gap_size']['value']
//						newMount.colour = this.top_mount_colour
//					}
					
					this.$emit('setmount', newMount)
					
					//console.log(newMount)
				})
			}
		}
    }
</script>