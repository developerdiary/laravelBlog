@extends('layouts.admin-master')

@section('title')
Tags
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Tag</h1>
  </div>
  <div class="section-body">
      <admin-tag-component></admin-tag-component>
  </div>
</section>
@endsection