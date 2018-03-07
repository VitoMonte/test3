<div class="form-group @if($errors->get($field)) has-error has-feedback @endif">

	<label for="{{ $field }}" class="control-label">{{ $name }}</label>

	@yield('field')
	
	@foreach($errors->get($field) as $message)
		<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
		<div class="control-label">{!! $message !!} Try another?</div>
	@endforeach

</div>