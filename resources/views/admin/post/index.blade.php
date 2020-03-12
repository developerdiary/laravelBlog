@extends('layouts.admin-master')

@section('title')
Manage Post
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Post</h1>
  </div>
  <div class="section-body">
      <admin-post-component></admin-post-component>
  </div>
</section>
@endsection