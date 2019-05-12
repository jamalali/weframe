import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

function orderItemDefaults() {
	return {
		artworkDescription	: '',
		moulding			: 0,
		mount: {
			type: 'none'
		},
		glazing			: '0',
		fixing			: '0',
		artworkMounting	: '0',
		artworkSupplied	: '0',
		boxFrame		: '0',
		foamBoard		: '0'
	}
}

export const store = new Vuex.Store({
	
	state: {
		orderItem		: orderItemDefaults(),
		basket			: [],
		orderItemPrice	: {},
		orderType		: '0',
	},
	
	getters: {
		
		basketTotal: state => {
			
			let total = 0
			
			for (const key in state.basket) {
				let line = state.basket[key]
				let lineTotal = line.total
				
				lineTotal = parseFloat(lineTotal)
				
				if (!isNaN(lineTotal)) {
					total = total + lineTotal
				}
			}
			
			return total.toFixed(2);
		},
		
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
		setOrderType ({commit}, orderType) {
			commit('orderType', orderType)
		},
		
		updateOrderItem ({state, commit}, orderItem) {
			
			state.orderItem.orderType = state.orderType
			
			commit('orderItem', orderItem)
			commit('orderItemPrice')
		},
		
		addToBasket ({state, getters, commit}) {
			state.orderItem.total = getters.orderItemTotal
			commit('basket', state.orderItem)
			
			// clear the current orderItem
			commit('resetOrderItem')
			commit('resetOrderItemPrice')
		},
		
		createOrder ({state}) {
			
			console.log(state.basket)
			
			axios.post('http://weframe.local/api/order', {
				order_type: state.orderType,
				lines: state.basket
			}).then(response => (
				console.log(response.data)
			))
		}
	},
	
	mutations: {
		orderType (state, orderType) {
			state.orderType = orderType
		},
		
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