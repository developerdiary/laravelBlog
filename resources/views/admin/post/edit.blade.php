@extends('layouts.admin-master')

@section('title')
Edit Post ({{ $post->title }})
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Edit Post</h1>
  </div>
  <div class="section-body">      
      <admin-editpost-component post='{{ $post }}'></admin-editpost-component>
  </div>
</section>
@endsection