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
					<button class="button" v-for="(type, typeKey) in job_types" v-on:click.prevent="setJobType(typeKey)" v-bind:class="{'is-info is-selected': job_type==typeKey}">
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
			
			<mount-selector
				v-bind:mounts="mounts"
				v-on:setmount="setMount"
			></mount-selector>
			
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
					<button class="button" v-for="(fixingOpt, fixingOptKey) in fixings" v-on:click.prevent="setFixingType(fixingOptKey)" v-bind:class="{'is-info is-selected': fixing==fixingOptKey}">
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
					<button class="button" v-for="(artworkMounting, artworkMountingKey) in artwork_mountings" v-on:click.prevent="setArtworkMounting(artworkMountingKey)" v-bind:class="{'is-info is-selected': artwork_mounting==artworkMountingKey}">
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
	import MountSelector from './MountSelector.vue';
    export default {
		components: {
			'mount-selector': MountSelector
		},
		data() {
			return {
				job_type: 'walk_in',
				
				artwork_supplied	: 0,
				box_frame			: 0,
				fixing				: '0',
				artwork_mounting	: '0',
				
				mount: {
					'type': 'none'
				}
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
		methods: {
			
			setMount: function(data) {
				this.mount = data
				this.getPrice()
			},
			
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
					
					// Job type and other options
					params.job_type				= this.job_type
					params.artwork_supplied		= this.artwork_supplied
					params.box_frame			= this.box_frame
					params.fixing				= this.fixing
					params.artwork_mounting		= this.artwork_mounting
					
					// Mould params
					params.mould = this.$refs['mould']['value']
					
					params.mount = this.mount
					
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
