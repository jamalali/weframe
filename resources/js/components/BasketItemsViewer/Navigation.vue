<template>
	<div>
		<div class="buttons has-addons is-right">
			<span class="button" v-model="prevItem" v-bind:disabled="prevItem===false" @click="setItem(prevItem)">
				<i class="fas fa-chevron-left"></i>
			</span>
			<span class="button" v-model="nextItem" v-bind:disabled="nextItem===false" @click="setItem(nextItem)">
				<i class="fas fa-chevron-right"></i>
			</span>
		</div>
	</div>
</template>
<script>
	import { mapState, mapGetters } from 'vuex'
    export default {
		data() {
			return {
				prevItem: false,
				nextItem: false
			}
		},
		watch: {
			showBasketItem: function() {
				this.setButtons()
			}
		},
		methods: {
			setItem: function(newItem) {
				if (newItem !== false) {
					this.$store.commit('showBasketItem', newItem)
					this.setButtons()
				}
			},
			setButtons: function() {
				
				this.$nextTick(function() {
					
					let numItems = this.basket.length - 1 // minus 1 so the count starts at 0

					// check to see if we have any previous and next items
					if (this.showBasketItem == 0) {
						this.prevItem = false
					} else {
						this.prevItem = this.showBasketItem - 1
					}
					
					if (this.showBasketItem == numItems) {
						this.nextItem = false
					} else {
						this.nextItem = this.showBasketItem + 1
					}
				})
			}
		},
		computed: {
			...mapState({
				basket: state => state.basket
			}),
			...mapGetters([
				'showBasketItem'
			])
		}
    }
</script>