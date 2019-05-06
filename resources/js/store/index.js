import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		calculation: {}
	},
	getters: {
		calculationTotal: state => {
			
			let total = 0
			
			for (const key in state.calculation) {
				let value = state.calculation[key]
				
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
	mutations: {
		updateCalculation (state, updatedCalculation) {
			state.calculation = updatedCalculation
		}
	}
})