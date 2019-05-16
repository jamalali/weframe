<template>
	<div class="modal" v-bind:class="{'is-active': showBasketItems}">
		<div class="modal-background" @click="closeBasketViewer"></div>
		<div class="modal-card">
			<section class="modal-card-body">
				<div class="columns">
					<div class="column is-full" v-for="(line, key) in basket">
						<table class="table is-fullwidth">
							<tr v-for="(item, key) in line" :class="key | camelToKebab">
								
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
					</div>
				</div>
			</section>
		</div>
	</div>
</template>
<script>
	import { mapState } from 'vuex'
    export default {
		props: {
			order_types: '',
			moulds: {},
		},
		methods: {
			closeBasketViewer: function() {
				this.$store.dispatch('closeBasketViewer')
			},
			setOrderType: function(typeKey) {
				this.$store.dispatch('setOrderType', typeKey)
			}
		},
		computed: {
			...mapState({
				basket: state => state.basket,
				showBasketItems: state => state.showBasketItems,
				showBasketItem: state => state.showBasketItem
			})
		}
    }
</script>