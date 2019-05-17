<template>
	<div class="modal" v-bind:class="{'is-active': showBasketItem!==false}">
		<div class="modal-background" @click="closeBasketViewer"></div>
		<div class="modal-card">
			<section class="modal-card-body">
				
				<navigation
					v-bind:item="showBasketItem"
				></navigation>
						
				<table class="table is-fullwidth">

					<tr v-for="(item, key) in basket[showBasketItem]" :class="key | camelToKebab">

						<th v-if="key!='artworkDescription'&&key!='total'" style="white-space: nowrap">
							{{ key | keyToSentence }}
						</th>
						<th v-else></th>

						<td v-if="key=='artworkDescription'">
							<h5 class="title is-4">
								{{ item }}
							</h5>
						</td>
						<td v-else-if="key=='moulding'">
							{{ moulds[item].name }}
						</td>
						<td v-else-if="key=='total'">
							<h5 class="title is-4">
								{{ item | currency }}
							</h5>
						</td>
						<td v-else>
							{{ item }}
						</td>

					</tr>

				</table>
						
			</section>
		</div>
	</div>
</template>
<script>
	import { mapState } from 'vuex'
	import Navigation from './Navigation.vue';
    export default {
		components: {
			'navigation': Navigation
		},
		props: {
			order_types: '',
			moulds: {},
		},
		methods: {
			closeBasketViewer: function() {
				this.$store.dispatch('closeBasketViewer')
			}
		},
		computed: {
			...mapState({
				basket: state => state.basket,
				showBasketItem: state => state.showBasketItem
			})
		}
    }
</script>