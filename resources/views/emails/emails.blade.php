@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<h1>Emails</h1>
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
				      <th scope="col">Title</th>
				      <th scope="col"></th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($emails as $email)
					    <tr>
					      <td>{{ $email->id }}</td>
					      <td>{{ $email->title }}</td>
					      <td><a href="javascript:void(0)" onclick="getSource({{ $email->id }})">Edit</a></td>
					    </tr>
					@endforeach
				  </tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card card-default">
				<form method="post" action="/email/add">
					{{ csrf_field() }}
	                <div class="card-header">
	                    Add Email
	                </div>
	                <div class="card-body">
	                	<div class="form-group">
	                		<input type="text" class="form-control" name="title" placeholder="Title of Email"/>
	                	</div>
	                	
	                	<button type="submit" class="btn btn-success">Add Email</button>
	                </div>
	            </form>
            </div>
        </div>
	</div>
	</div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="edit-source">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="post" action="/source/edit">
	      <div class="modal-header">
	        <h5 class="modal-title">Edit Email</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
				{{ csrf_field() }}

				<input type="hidden" id="id" name="id"/>
	           
            	<div class="form-group">
            		<input type="text" class="form-control" name="title" placeholder="Title of Email" id="title"/>
            	</div>
	            
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-success">Save changes</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </form>
    </div>
  </div>
</div>





@endsection