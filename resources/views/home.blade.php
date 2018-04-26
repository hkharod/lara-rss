@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

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

            <div class="form-group">
                <a class="btn btn-primary" href="/sources">Add New RSS Source</a>
            </div>
            
            <form method="POST" action="/search">
            {{ csrf_field() }}
                <div class="row search-bar">
                  <div class="col-lg-12">
                    <div class="input-group">
                      <input type="text" class="form-control" name="search" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Search</button>
                      </span>
                    </div>
                  </div>
                </div>
            </form>

            @foreach($items as $item)
                <div class="media"> 
                    <div class="media-body"> 
                        <a href="{{ $item->link }}"><h4 class="media-heading">{{ $item->title }}</h4></a>
                        <span class="source-title"> {{ $item->source_title }} </span>
                        <div class="description">{{ $item->description }}</div> 
                        <i>Posted {{ $item->post_date }} by {{ $item->author }}</i>
                    </div> 
                </div>
            @endforeach
                
        </div>
    </div>
</div>
@endsection
