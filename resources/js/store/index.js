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
		customerId		: false,
		
		showBasketItem	: false,
	},
	
	getters: {
		
		showBasketItem: state => {
			
			return state.showBasketItem
			
		},
		
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
		closeBasketViewer ({state}) {
			state.showBasketItem = false
		},
		
		viewBasketItem ({state}, key) {
			state.showBasketItem = key
		},
		
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
		
		createOrder ({state, getters}) {			
			axios.post('http://admin.weframe.local/api/order', {
				customer_id	: state.customerId,
				type_id		: state.orderType,
				total		: getters.basketTotal,
				lines		: state.basket
			}).then(response => (
				window.location.href = '/orders/' + response.data.order_id
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
			axios.get('http://admin.weframe.local/api/price', {
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
		},
		
		showBasketItem (state, itemKey) {
			state.showBasketItem = itemKey
		},
		
		customerId (state, customerId) {
			state.customerId = customerId
		}
	}
})