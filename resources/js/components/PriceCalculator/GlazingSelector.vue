<template>
	<div id="mount-selector">
		<label class="label" for="glazing">
			Glazing
		</label>
		<div class="columns">
			<div class="field column is-one-third">
				<div class="control">
					<div class="select">
						<select v-model="glazingCategory" id="glazing">
							<option value="0">
								None
							</option>
							<option v-for="(glazing, id) in glazings" :value="id">
								{{ glazing.name }}
							</option>
						</select>
					</div>
				</div>
			</div>
			<div class="field column is-two-thirds">
				<div class="control" v-if="glazingOptions">
					<div class="select">
						<select v-model="glazingOption" id="glazing">
							<option value="0">
								- Select
							</option>
							<option v-for="(opt, optId) in glazingOptions" :value="optId">
								{{ opt.name }}
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
    export default {
		data() {
			return {
				glazingCategory	: 0,
				glazingOptions	: false,
				glazingOption	: 0
			}
		},
		props: {
			glazings: '',
			glazing: 0
		},
		watch: {
			glazing: function(newValue) {
				if (newValue == 0) {
					this.glazingCategory = 0
					this.glazingOptions	= false
					this.glazingOption = 0
				}
			},
			glazingCategory: function(newValue) {
				if (newValue != 0) {
					let selectedCategory = this.glazings[newValue]
					let hasOptions = ('options' in selectedCategory) ? true : false

					if (hasOptions) {
						this.glazingOptions = selectedCategory['options']
						this.glazingOption = 0
					} else {
						this.glazingOptions = false
						this.returnGlazing()
					}
				}
			},
			glazingOption: function(newValue) {
				if (newValue != 0) {
					this.returnGlazing()
				}
			}
		},
		methods: {
			returnGlazing: function() {
				
				this.$nextTick(function() {
				
					let glazing = this.glazingCategory

					if (this.glazingOptions) {
						glazing = glazing + '-' + this.glazingOption
					}

					//console.log('selected glazing is ' + glazing)

					this.$emit('setglazing', glazing)
				})
			}
		},
		computed: {
			...mapState({
				orderItem: state => state.orderItem
			})
		}
    }
</script>