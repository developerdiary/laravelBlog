@extends('layouts.admin-master')

@section('title')
Create Post
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Add New Post</h1>
  </div>
  <div class="section-body">
      <admin-addPost-component></admin-addPost-component>
  </div>
</section>
@endsection
