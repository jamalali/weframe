@extends('layouts.app')

@section('content')
<div class="columns is-centered">
	<div class="column is-half-tablet is-one-third-desktop">
		<div class="box">
			<h1 class="title is-1">
				{{ __('Login') }}
			</h1>

			<form method="POST" action="{{ route('login') }}">
				@csrf

				<div class="field">
					<label for="username" class="label">
						{{ __('Username') }}
					</label>

					<div class="control">
						<input id="username" type="text" class="input {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

						@if ($errors->has('username'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('username') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="field">
					<label for="password" class="label">
						{{ __('Password') }}
					</label>

					<div class="control">
						<input id="password" type="password" class="input {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

						@if ($errors->has('password'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="field">
					<div class="control">
						<label class="checkbox">
							<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
							{{ __('Remember Me') }}
						</label>
					</div>
				</div>

				<div class="field is-grouped">
					<div class="control">
						<button type="submit" class="button is-primary">
							{{ __('Login') }}
						</button>
					</div>

					@if (Route::has('password.request'))
						<div class="control">
							<a href="{{ route('password.request') }}">
								{{ __('Forgot Your Password?') }}
							</a>
						</div>
					@endif
				</div>

			</form>
		</div>
	</div>
</div>
@endsection