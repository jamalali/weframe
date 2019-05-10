<template>
	<div class="basket-container">
		<h4 class="title is-4">
			Basket
		</h4>
		<div v-if="Object.keys(basket).length">
			<div class="columns is-multiline">
				<div class="column is-full" v-for="(line, key) in basket">
					{{ line.artworkDescription }}
					<span class="is-pulled-right">
						{{ line.total | currency }}
					</span>
				</div>
				<div class="column is-full">
					<span class="title is-5">
						Total
					</span>
					<span class="title is-5 is-pulled-right">
						{{ basketTotal | currency }}
					</span>
				</div>
			</div>
		</div>
		<p v-else>
			empty
		</p>
	</div>
</template>

<script>
	import { mapState, mapGetters } from 'vuex'
    export default {
		methods: {
		},
		computed: {
			...mapState({
				basket: state => state.basket
			}),
			...mapGetters([
				'basketTotal'
			])
		}
    }
</script>