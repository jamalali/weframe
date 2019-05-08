<template>
	<div class="calculation-display"  v-if="Object.keys(orderItemPrice).length">
		<h4 class="title is-4">
			Item Price
		</h4>
		<div class="columns is-multiline">
			<div class="column is-full" v-for="(price, key) in orderItemPrice">
				{{ key | keyToLabel }}
				<span class="is-pulled-right" v-if="typeof price !== 'object'">
					{{ price | currency }}
				</span>
				<div v-else v-for="(priceChild, keyChild) in price">
					- {{ keyChild | keyToLabel }}
					<span class="is-pulled-right">
						{{ priceChild | currency }}
					</span>
				</div>
			</div>
			<div class="column is-full">
				<span class="title is-5">
					Total
				</span>
				<span class="title is-5 is-pulled-right">
					{{ orderItemTotal | currency }}
				</span>
			</div>
		</div>
		<div>
			<button class="button is-success" @click="addToBasket">
				Add to basket
			</button>
		</div>
	</div>
</template>

<script>
	import { mapState, mapGetters } from 'vuex'
    export default {
		methods: {
			addToBasket: function() {
				this.$store.dispatch('addToBasket')
			}
		},
		computed: {
			...mapState({
				orderItemPrice: state => state.orderItemPrice
			}),
			...mapGetters([
				'orderItemTotal'
			])
		}
    }
</script>