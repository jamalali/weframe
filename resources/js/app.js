import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./bulma.js');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('price-calculator', require('./components/PriceCalculator/Index.vue').default);
Vue.component('calculation-display-admin', require('./components/CalculationDisplayAdmin.vue').default);
Vue.component('mount-variants', require('./components/MountVariants.vue').default);

Vue.filter('keyToLabel', function (value) {
	if (!value) return ''
	value = value.toString()
	value = value.replace(/_/g, ' ')
	return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('currency', function (value) {
	if (isNaN(parseFloat(value))) return value
	return '£' + value
})

const store = new Vuex.Store({
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
	store
});
