<template>
	<div class="calculation-display"  v-if="Object.keys(calculation).length">
		<h4 class="title is-4">
			Price calculation
		</h4>
		<div class="columns is-multiline">
			<div class="column is-full" v-for="(price, key) in calculation">
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
					{{ calculationTotal | currency }}
				</span>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState, mapGetters } from 'vuex'
    export default {
		computed: {
			...mapState({
				calculation: state => state.calculation
			}),
			...mapGetters([
				'calculationTotal'
			])
		}
    }
</script>
