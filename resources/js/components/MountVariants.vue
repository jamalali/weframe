<template>
	<div>
		<table class="table">
			<thead>
				<tr>
					<th>
						Colour
					</th>
					<th>
						SKU
					</th>
					<th>
						Inventory
					</th>
					<th>
						Price
					</th>
					<th></th>
				</tr>
			</thead>
			<tr>
				<td>
					<input class="input" type="text" ref="new-variant-colour">
				</td>
				<td>
					<input class="input" type="text" ref="new-variant-sku">
				</td>
				<td>
					<input class="input" type="text" ref="new-variant-inventory">
				</td>
				<td>
					<input class="input" type="text" ref="new-variant-price">
				</td>
				<td>
					<button type="button" class="button is-info is-small" v-on:click="addVariant(newIndex)">
						Add
					</button>
				</td>
			</tr>
			<tr v-for="(variant, index) in variantsList" :key="index">
				<td>
					<input class="input" type="text" :name="'variants[' + index + '][colour]'" :value="variantsList[index].colour">
				</td>
				<td>
					<input class="input" type="text" :name="'variants[' + index + '][sku]'" :value="variantsList[index].sku">
				</td>
				<td>
					<input class="input" type="text" :name="'variants[' + index + '][inventory]'" :value="variantsList[index].inventory">
				</td>
				<td>
					<input class="input" type="text" :name="'variants[' + index + '][price]'" :value="variantsList[index].price">
				</td>
				<td></td>
			</tr>
		</table>
	</div>
</template>

<script>
    export default {
		data() {
			return {
				variantsList: {},
				variantsCount: 0,
				newIndex: 0
			}
		},
		methods: {
			addVariant: function (index) {
				let new_sku = this.$refs['new-variant-sku']['value']
				let new_colour = this.$refs['new-variant-colour']['value']
				let new_inventory = this.$refs['new-variant-inventory']['value']
				let new_price = this.$refs['new-variant-price']['value']
				
				this.$set(this.variantsList, index, {
					sku: '',
					colour: '',
					inventory: '',
					price: ''
				})
				
				this.$set(this.variantsList[index], 'sku', new_sku)
				this.$set(this.variantsList[index], 'colour', new_colour)
				this.$set(this.variantsList[index], 'inventory', new_inventory)
				this.$set(this.variantsList[index], 'price', new_price)
				
				this.variantsCount = Object.keys(this.variantsList).length
				this.newIndex = this.variantsCount++
				
				this.$refs['new-variant-sku']['value'] = ''
				this.$refs['new-variant-colour']['value'] = ''
				this.$refs['new-variant-inventory']['value'] = ''
				this.$refs['new-variant-price']['value'] = ''
			}
		}
    }
</script>
