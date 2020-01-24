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
      <category-component></category-component>
  </div>
</section>
@endsection