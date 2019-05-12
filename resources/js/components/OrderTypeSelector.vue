<template>
	<div class="modal" v-bind:class="{'is-active': orderType=='0'}">
		<div class="modal-background"></div>
		<div class="modal-card">
			<section class="modal-card-body">
				<h4 class="title is-4 has-text-centered">
					Choose the order type
				</h4>
				<div class="buttons has-addons is-centered">
					<button class="button" v-for="type in order_types" v-on:click.prevent="setOrderType(type.id)">
						{{ type.label }}
					</button>
				</div>
			</section>
		</div>
	</div>
</template>
<script>
	import { mapState } from 'vuex'
    export default {
		props: {
			order_types: ''
		},
		methods: {
			setOrderType: function(typeKey) {
				this.$store.dispatch('setOrderType', typeKey)
			}
		},
		computed: {
			...mapState({
				orderType: state => state.orderType
			})
		}
    }
</script>