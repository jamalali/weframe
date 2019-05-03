<template>
	<div class="field">
		<label class="label" for="moulding">
			Moulding
		</label>
		<div class="control">
			<div class="select is-multiple">
				<select ref="moulding" id="moulding" size="5" multiple v-on:change="returnMoulding">
					<option value="0" selected>
						Choose one
					</option>
					<option v-for="(mould, mouldIndex) in moulds" :value="mouldIndex">
						{{ mould.name }}
					</option>
				</select>
			</div>
		</div>
	</div>
</template>
<script>
    export default {
		data() {
			return {}
		},
		props: {
			moulds: '',
		},
		methods: {
			returnMoulding: function() {
				const moulding = this.$refs['moulding']['value']
				this.$emit('setmoulding', moulding)
			}
		}
    }
</script>