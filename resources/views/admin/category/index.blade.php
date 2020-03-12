@extends('layouts.admin-master')

@section('title')
Manage Post Category
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Post Category</h1>
  </div>
  <div class="section-body">      
      <admin-category-component></admin-category-component>
  </div>
</section>
@endsection