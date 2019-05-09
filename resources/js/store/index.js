import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

function orderItemDefaults() {
	return {
		jobType: 'walk_in',
		moulding: 0,
		mount: {
			type: 'none'
		},
		glazing: '0',
		fixing: '0',
		artworkMounting: '0',
		artworkSupplied: '0',
		boxFrame: '0',
		foamBoard: '0'
	}
}

export const store = new Vuex.Store({
	state: {
		orderItem: orderItemDefaults(),
		basket: [],
		orderItemPrice: {}
	},
	getters: {
		
		orderItemTotal: state => {
			
			let total = 0
			
			for (const key in state.orderItemPrice) {
				let value = state.orderItemPrice[key]
				
				if (typeof value == 'object') {
					
					for (const childKey in value) {
						let childValue = value[childKey]
						
						childValue = parseFloat(childValue)
						
						if (!isNaN(childValue)) {
							total = total + childValue
						}
					}
					
				} else {
					
					value = parseFloat(value)
				
					if (!isNaN(value)) {
						total = total + value
					}
				}
			}
			
			return total.toFixed(2);
		}
	},
	
	actions: {
		updateOrderItem ({commit}, orderItem) {
			commit('orderItem', orderItem)
			commit('orderItemPrice')
		},
		
		addToBasket ({state, getters, commit}) {
			state.orderItem.total = getters.orderItemTotal
			commit('basket', state.orderItem)
			
			// clear the current orderItem
			commit('resetOrderItem')
			commit('resetOrderItemPrice')
		}
	},
	
	mutations: {
		orderItem (state, orderItem) {
			state.orderItem = orderItem
		},
		
		resetOrderItem (state) {
			state.orderItem = orderItemDefaults()
		},
		
		orderItemPrice (state) {
			axios.get('http://weframe.local/api/price', {
				params: state.orderItem
			}).then(response => (
				state.orderItemPrice = response.data
			))
		},
		
		resetOrderItemPrice (state) {
			state.orderItemPrice = {}
		},
		
		basket (state, item) {
			state.basket.push(item)
		}
	}
})