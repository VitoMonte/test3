@extends('fields.main')

@section('field')
	<input type="text" class="form-control" name="{{ $field }}" value="{{ old($field ,(isset($entity) ? $entity->$field : '')) }}" >
@overwrite