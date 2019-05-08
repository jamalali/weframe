<template>
	<div class="basket-container">
		<h4 class="title is-4">
			Basket
		</h4>
		<div v-if="Object.keys(basket).length">
			<div class="columns is-multiline">
				<div class="column is-full" v-for="(line, key) in basket">
					{{ key }}
					<span class="is-pulled-right">
						{{ line.total | currency }}
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
			})
		}
    }
</script>