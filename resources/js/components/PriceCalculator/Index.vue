<template>
	<div id="price-calculator">
		
		<div class="field is-horizontal">
			<div class="field-label" style="flex-grow: 2;">
				<label class="label has-text-left" for="artwork_description">
					Artwork description
				</label>
			</div>
			<div class="field-body">
				<div class="field">
					<p class="control">
						<input class="input" type="text" v-model="orderItem.artworkDescription" id="artwork_description">
					</p>
				</div>
			</div>
		</div>
		
		<hr />
		
		<div class="field is-horizontal">
			<div class="field-label" style="flex-grow: 2;">
				<label class="label has-text-left" for="artwork_supplied">
					Artwork Supplied?
				</label>
			</div>
			<div class="field-body">
				<div class="field">
					<div class="control">
						<ul>
							<li style="display:inline-block; margin-right: 20px;">
								<label class="radio">
									<input type="radio" value="0" v-on:change="getPrice" v-model="orderItem.artworkSupplied" checked>
									No
								</label>
							</li>
							<li style="display:inline-block">
								<label class="radio">
									<input type="radio" value="1" v-on:change="getPrice" v-model="orderItem.artworkSupplied">
									Yes
								</label>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<hr />

		<moulding-selector
			v-bind:moulds="moulds"
			v-bind:moulding="orderItem.moulding"
			v-on:setmoulding="setMoulding"
		></moulding-selector>

		<hr />
		
		<div class="field is-horizontal">
			<div class="field-label" style="flex-grow: 2;">
				<label class="label has-text-left">
					Artwork size
				</label>
			</div>
			<div class="field-body">
				<div class="columns">
					<div class="field column is-one-quarter">
						<label class="label is-size-7 has-text-weight-normal" for="artwork_width">
							Width (mm)
						</label>
						<div class="field">
							<div class="control">
								<input v-model="orderItem.artworkWidth" v-on:keydown="typingTimeout" id="artwork_width" class="input" type="text">
							</div>
						</div>
					</div>
					<div class="field column is-one-quarter">
						<label class="label is-size-7 has-text-weight-normal" for="artwork_height">
							Height (mm)
						</label>
						<div class="field">
							<div class="control">
								<input v-model="orderItem.artworkHeight" v-on:keydown="typingTimeout" id="artwork_height" class="input" type="text">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<hr />

		<mount-selector
			v-bind:mounts="mounts"
			v-bind:mount="orderItem.mount"
			v-on:setmount="setMount"
		></mount-selector>
		
		<hr />

		<div>
			<label class="label">
				Artwork mounting
			</label>
			<div class="buttons has-addons">
				<button class="button" v-for="(artworkMountingValue, artworkMountingKey) in artwork_mountings" v-on:click.prevent="setArtworkMounting(artworkMountingKey)" v-bind:class="{'is-info is-selected': orderItem.artworkMounting==artworkMountingKey}">
					{{ artworkMountingValue.name }}
				</button>
			</div>
		</div>

		<hr />
		
		<glazing-selector
			v-bind:glazings="glazings"
			v-bind:glazing="orderItem.glazing"
			v-on:setglazing="setGlazing"
		></glazing-selector>

		<hr />

		<div>
			<label class="label">
				Fixing
			</label>
			<div class="buttons has-addons">
				<button class="button" v-for="(fixingOpt, fixingOptKey) in fixings" v-on:click.prevent="setFixingType(fixingOptKey)" v-bind:class="{'is-info is-selected': orderItem.fixing==fixingOptKey}">
					{{ fixingOpt.name }}
				</button>
			</div>
		</div>

		<hr />

		<div class="columns is-multiline">
			<div class="field column is-one-third is-one-fifth-desktop">
				<label class="label">
					Box Lining?
				</label>
				<div class="control">
					<ul>
						<li>
							<label class="radio">
								<input type="radio" value="0" v-on:change="getPrice" v-model="orderItem.boxFrame" checked>
								No
							</label>
						</li>
						<li>
							<label class="radio">
								<input type="radio" value="1" v-on:change="getPrice" v-model="orderItem.boxFrame">
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
						<select v-model="orderItem.foamBoard" id="foam_board" v-on:change="getPrice">
							<option value="0">
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
	</div>
</template>
<script>
	import { mapState } from 'vuex'
	import MountSelector from './MountSelector.vue'
	import MouldingSelector from './MouldingSelector.vue'
	import GlazingSelector from './GlazingSelector.vue'
    export default {
		components: {
			'mount-selector'	: MountSelector,
			'moulding-selector'	: MouldingSelector,
			'glazing-selector'	: GlazingSelector
		},
		data() {
			return {
			}
		},
		props: {
			mounts				: '',
			glazings			: {},
			foam_boards			: '',
			moulds				: {},
			fixings				: '',
			artwork_mountings	: '',
			customer_id			: false
		},
		methods: {
			setMoulding: function(moulding_id) {
				this.orderItem.moulding = moulding_id
				if (moulding_id != 0) {
					this.getPrice()
				}
			},
			
			setMount: function(data) {
				this.orderItem.mount = data
				this.getPrice()
			},
			
			setGlazing: function(value) {
				this.orderItem.glazing = value
				this.getPrice()
			},
			
			setArtworkMounting: function(artworkMountingKey) {
				this.orderItem.artworkMounting = artworkMountingKey
				this.getPrice()
			},
			
			setFixingType: function(fixingOptKey) {
				this.orderItem.fixing = fixingOptKey
				this.getPrice()
			},
			
			typingTimeout: function(event) {
				
				if (this.timer) {
					clearTimeout(this.timer);
					this.timer = null;
				}
				this.timer = setTimeout(() => {
					//console.log(this.orderItem)
					this.getPrice()
				}, 1000);
			},
			
			getPrice: function() {
				
				this.$nextTick(function() {
					
					// Required options - check them
					if (this.orderItem.moulding == 0) {
						alert('Please choose a moulding')
						return false
					}
					
					this.$store.dispatch('updateOrderItem', this.orderItem)
				})
			}
		},
		mounted: function() {
			this.$store.commit('customerId', this.customer_id)
		},
		computed: {
			...mapState({
				orderItem: state => state.orderItem,
				customerID: state => state.customerID,
			})
		}
    }
</script>