@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<h1>Sources</h1>
		</div>
	</div>

	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
     @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
     @elseif (session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
        </div>
    @endif

	<div class="row">
        <div class="col-md-8">
			<div class="table">
				<table class="table">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Name</th>
				      <th scope="col">Last Run</th>
				      <th scope="col"></th>
				      <th scope="col"></th>
				    </tr>
				  </thead>
				  <tbody>
				  	@if($sources->isEmpty())
				  		<tr>
							<td>No Sources</td>
						</tr>
				  	@endif
				  	@foreach($sources as $source)
					    <tr>
					      <td>{{ $source->id }}</td>
					      <td>{{ $source->title }}</td>
					      <td>{{ $source->last_run }}</td>
					      <td><a href="javascript:void(0)" onclick="getSource({{ $source->id }})">Edit</a></td>
					      <td><a href="/source/execute/{{$source->id}}">Run</a></td>
					    </tr>
					@endforeach
				  </tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card card-default">
				<form method="post" action="/source/add">
					{{ csrf_field() }}
	                <div class="card-header">
	                    Add Source
	                </div>
	                <div class="card-body">
	                	<div class="form-group">
	                		<input type="text" class="form-control" name="title" placeholder="Title of Source" required/>
	                	</div>
	                	<div class="form-group">
	                		<input type="text" class="form-control" name="rss_url" placeholder="RSS Feed URL" required/>
	                	</div>
	                	<button type="submit" class="btn btn-success">Add Source</button>
	                </div>
	            </form>
            </div>
        </div>
	</div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="edit-source">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Source</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<form method="post" action="/source/edit">
				{{ csrf_field() }}

				<input type="hidden" id="id" name="id"/>
	           
            	<div class="form-group">
            		<input type="text" class="form-control" name="title" placeholder="Title of Source" id="title" required/>
            	</div>
            	<div class="form-group">
            		<input type="text" class="form-control" name="rss_url" placeholder="RSS Feed URL" id="rss-url" required/>
            	</div>

            	<button type="submit" class="btn btn-success">Save changes</button>
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <form method="post" action="/source/delete">
		    	{{ csrf_field() }}
		    	<input type="hidden" id="delete-id" name="id"/>
		    	<button type="submit" class="btn btn-danger">Delete</button>
		    </form>
	      </div>
    </div>
  </div>
</div>

@endsection