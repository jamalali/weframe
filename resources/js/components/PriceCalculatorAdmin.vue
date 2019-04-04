<template>
    <form class="is-horizontal is-2-col">

		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label" for="mould_cost">
					Mould cost (£ per metre)
				</label>
			</div>

			<div class="field-body">
				<div class="control">
					<input ref="mould_cost" v-on:keyup="getPrice" id="mould_cost" class="input" type="text">
				</div>
			</div>
		</div>

		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label" for="mould_width">
					Mould width (mm)
				</label>
			</div>

			<div class="field-body">
				<div class="control">
					<input ref="mould_width" v-on:keyup="getPrice" id="mould_width" class="input" type="text">
				</div>
			</div>
		</div>

		<hr />

		<div class="field is-horizontal">

			<div class="field-label is-normal">
				<label class="label">
					Glass size
				</label>
			</div>

			<div class="field-body columns">

				<div class="field column">
					<label class="label is-size-7 has-text-weight-normal" for="glass_size_width">
						Width
					</label>

					<div class="field">
						<div class="control">
							<input ref="glass_size_width" v-on:keyup="getPrice" id="glass_size_width" class="input" type="text">
						</div>
					</div>
				</div>

				<div class="field column">
					<label class="label is-size-7 has-text-weight-normal" for="glass_size_height">
						Height
					</label>

					<div class="field">
						<div class="control">
							<input ref="glass_size_height" v-on:keyup="getPrice" id="glass_size_height" class="input" type="text">
						</div>
					</div>
				</div>

			</div>

		</div>

		<hr />
		
		<div class="control">
			<a class="button is-warning" href="/admin/orders">
				Cancel
			</a>
		</div>
	</form>
</template>

<script>
    export default {
		methods: {
				
			getPrice: function(event) {
				
				axios.get('http://weframe.local/api/price', {
					params: {
						mould_cost: this.$refs['mould_cost']['value'],
						mould_width: this.$refs['mould_width']['value'],
						glass_size_width: this.$refs['glass_size_width']['value'],
						glass_size_height: this.$refs['glass_size_height']['value']
					}
				})
				.then(response => (
					console.log(response.data)
				))
			}
		}
    }
</script>
