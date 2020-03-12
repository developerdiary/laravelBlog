@extends('layouts.admin-master')

@section('title')
Create Tag
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Add Tag</h1>
  </div>
  <div class="section-body">
      <admin-addTag-component></admin-addTag-component>
  </div>
</section>
@endsection