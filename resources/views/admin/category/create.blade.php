@extends('layouts.admin-master')

@section('title')
Create Category
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Add Category</h1>
  </div>
  <div class="section-body">
      <admin-addCategory-component></admin-addCategory-component>
  </div>
</section>
@endsection