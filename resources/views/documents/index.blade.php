@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="row">
			<div class="col-md-6">
				<form method="POST" action="{{ route('search') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
		      <div class="form-group">
		        <input type="text" name="search" class="form-control" placeholder="Search" >
		      </div>
		    </form>
			</div>

			<div class="col-md-6 text-right">
				Sort: 
				<a href="{{ route('index', ['sort_by' => request('sort_by'), 'sort' => 'asc']) }}">Ascending</a> |  
				<a href="{{ route('index', ['sort_by' => request('sort_by'), 'sort' => 'desc']) }}">Descending</a> 
			</div>

		</div>
		<hr>	

		@if($documents->count() > 0)		
			<table class="table table-striped table-bordered">

				<thead>
					<tr>
						<th><a href="?sort_by=users.name">User</a></th>
						<th><a href="?sort_by=documents.title">Name</a></th>
						<th><a href="?sort_by=documents.created_at">Date</a></th>
						<th>File</th> 
					</tr>
				</thead>

				<tbody>
					@foreach($documents as $document)
					<tr>
						<td>{{$document->name}}</td>
						<td>{{$document->title}}</td>
						<td>{{$document->created_at}}</td>
						<td>
							<a href="{{ route('download',['filename' => $document->file_puth]) }}" class="btn-sm btn-primary">Download</a> 							
						 @can('editDocument', $document)
							<form action="{{ route('documents.destroy', $document->id) }}" method="post" style="display: inline-block;">
								<a type="btn" class="btn-sm btn-success" href="{{ route('documents.edit', $document->id) }}">Change name</a>
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button type="submit" class="btn-xs btn-danger">Delete</button>
							</form>
							@endcan
							
						</td>
					</tr>
					@endforeach	
				</tbody>

			</table>
			{{ $documents->links() }}

		@else
			No files
		@endif
	</div>

@endsection