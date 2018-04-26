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
            
             
            
            <form method="POST" action="/search">
            {{ csrf_field() }}
                <div class="form-group mb-2">
                    <input type="text" class="search" name="search" placeholder="Search Jobs"/>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </div>
            </form>
          
     

            <h3>Results for "{{ $data['term'] }}"</h3>

            @foreach($data['jobs'] as $job)
                <div class="card card-default">
                    <div class="card-header">
                        <b>{{ $job->job_title }}</b>
                        <div class="delete">
                            <a href="/job/delete/{{$job->id}}">Delete</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="job">
                            <div class="heading">
                                {{ $job->post_date}}<br/>
                                {{ $job->source }}
                            </div>
                            <div class="info">
                                <a href="{{ $job->url }}">URL Link</a> <br/>
                            </div>
                            <div class="tags">
                                Tech Tags: 
                                @if(!empty($job->tech_tags))
                                    @foreach($job->tech_tags as $tag)
                                        <span class="tag">{{ $tag }}</span>
                                    @endforeach 
                                @endif

                                <br/>
                                Type Tags: 
                                @if(!empty($job->position_tags))
                                    @foreach($job->position_tags as $tag)
                                        <span class="tag">{{ $tag }}</span>
                                    @endforeach 
                                @endif
                            </div>
                            <div class="actions">
                                <a href="/job/edit/{{ $job->id }}">Edit & Publish</a>
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
