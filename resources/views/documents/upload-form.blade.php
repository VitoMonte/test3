@extends('layouts.app')

@section('content')

<div class="container">  
  
  <div class="row">
    <div class=" col-md-12">
      <div class="panel panel-default">
          <div class="panel-heading">Add new file</div>
            <div class="panel-body">
               <form method="post" action="@if(empty($entity)){{ route('documents.store') }} @else {{ route('documents.update', $entity->id) }} @endif" enctype="multipart/form-data">  
                  {{ csrf_field() }}
                  @include('fields.text', ['field'=>'title', 'name'=>'Title'])
                  @if(empty($entity))
                    @include('fields.file', ['field'=>'file', 'name'=>'File'])  
                  @endif   
                  @isset($entity)
                    {{ method_field('PUT') }}
                  @endisset
                <button type="submit">Add</button>
              </form>
            </div>
      </div>
    </div>
  </div>

</div>



@endsection