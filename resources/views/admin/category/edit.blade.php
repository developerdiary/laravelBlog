@extends('layouts.admin-master')

@section('title')
Update Category
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Update Category</h1>
  </div>
  <div class="section-body">
      <editcategory-component category='{!! $category->toJson() !!}'></editcategory-component>
  </div>
</section>
@endsection
