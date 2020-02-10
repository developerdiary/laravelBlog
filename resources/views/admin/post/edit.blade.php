@extends('layouts.admin-master')

@section('title')
Edit Post ({{ $post->name }})
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Edit Post</h1>
  </div>
  <div class="section-body">
      <editpost-component post='{!! $post->toJson() !!}'></editpost-component>
  </div>
</section>
@endsection