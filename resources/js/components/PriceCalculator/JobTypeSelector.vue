<template>
	<div class="modal" v-bind:class="{'is-active': this.orderType==''}">
		<div class="modal-background"></div>
		<div class="modal-card">
			<section class="modal-card-body">
				<h4 class="title is-4 has-text-centered">
					Choose the order type
				</h4>
				<div class="buttons has-addons is-centered">
					<button class="button" v-for="(type, typeKey) in orderTypes" v-on:click.prevent="setOrderType(typeKey)">
						{{ type.label }}
					</button>
				</div>
			</section>
		</div>
	</div>
</template>
<script>
    export default {
		model: {
			prop: 'orderType',
			event: 'clicked'
		},
		props: {
			orderTypes: {},
			orderType: String
		},
		methods: {
			setOrderType: function(typeKey) {				
				this.$emit('clicked', typeKey)
			}
		}
    }
</script>