<template>
	<div id="moulding-selector">
		
		<div class="field is-horizontal">
			<div class="field-label" style="flex-grow: 2;">
				<label class="label has-text-left" for="moulding">
					Moulding
				</label>
			</div>
			<div class="field-body">
				<div class="field">
					<div class="control autocomplete">
						<input class="input" type="text" id="moulding" v-model="search" @input="onChange" />
						<a class="delete is-small" v-if="search!=''" @click="clearInput"></a>
						<ul v-show="isOpen" class="autocomplete-results">
							<li class="autocomplete-result" v-for="(result, i) in results" :key="i" @click="setResult(result, i)">
								{{ result.name }}
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>
<style>
  .autocomplete {
    position: relative;
  }

  .autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    max-height: 200px;
    overflow: auto;
	position: absolute;
	z-index: 4;
	width: 100%;
	background: #fff;
  }

  .autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 5px 9px;
    cursor: pointer;
  }

  .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
  }
</style>
<script>
    export default {
		data() {
			return {
				search: '',
				results: [],
				isOpen: false,
			}
		},
		props: {
			moulds: {},
			moulding: 0
		},
		watch: {
			moulding: function(newMoulding) {
				if (newMoulding == 0) {
					this.search = ''
				}
			}
		},
		methods: {
			clearInput() {
				this.search = ''
				this.isOpen = false
				this.$emit('setmoulding', 0)
			},
			
			setResult(result, result_id) {
				this.search = result.name
				this.isOpen = false
				this.$emit('setmoulding', result_id)
			},
			
			onChange(event) {
				if (event.target.value.length > 0) {
					this.isOpen = true
					this.filterResults()
				} else {
					this.$emit('setmoulding', 0)
					this.isOpen = false
				}
			},
			
			filterResults() {
				
				let filtered = {}
				
				for (const key in this.moulds) {
					let obj = this.moulds[key]
					let name = obj.name
					
					if (name.toLowerCase().indexOf(this.search.toLowerCase()) > -1) {
						filtered[key] = obj
					}
				}
				
				this.results = filtered
			}
		}
    }
</script>