@extends('layouts.admin-master')

@section('title')
Edit Tag
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Edit Tag</h1>
  </div>
  <div class="section-body">
      <admin-editTag-component tag='{!! $tag->toJson() !!}'></admin-editTag-component>
  </div>
</section>
@endsection