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
                <div class="form-group mb-2">
                    <input type="text" class="search form-control" name="search" placeholder="Search Jobs"/>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </div>
            </form>

            @foreach($items as $item)
                <div class="card card-default">
                    <div class="card-header">
                        <b>{{ $item->title }}</b><br/>
                        
                      
                        <div class="delete">
                            <a href="/job/delete/{{$item->id}}">Delete</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="job">
                            <div class="heading">
                                {{ $item->post_date}}<br/>
                                {{ $item->source_title }}
                            </div>
                            <div class="info">
                                <a href="{{ $item->link }}">URL Link</a> <br/>
                            </div>
                            <div class="actions">
                                <a target="blank" href="/job/emailedit/{{ $item->id }}">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
            @endforeach

                
        </div>
    </div>
</div>
@endsection
