@extends('layouts.app')

@section('content')
<div class="row">
    
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Dashboard</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <div class="row">
                  <div class="col-xl-12 col-sm-12">
                    <div class="card o-hidden small-widget">
                        <div class="card-body total-project border-l-primary border-3">
                        <span class="f-light f-w-500 f-14">Total</span>
                        <div class="project-details"> 
                            <div class="project-counter"> 
                                <h2 class="f-w-600 d-inline">{{ $total_candidates }}</h2>
                                Candidates
                            </div>
                            <div class="product-sub bg-primary-light">
                                <i class="las la-users la-2x"></i>
                            </div>
                        </div>
                        @include('components.bubbles')
                        </div>
                    </div>
                </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">Submitted</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{  $total_submitted }}</h2>
                                    Candidates
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-users la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">In progress</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{ $total_in_progress }}</h2>
                                    Candidates
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-users la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 ">
                        <div class="card o-hidden small-widget">
                            <div class="card-body border-l-primary border-3">
                            <span class="f-light f-w-500 f-14">Pending</span>
                            <div class="project-details"> 
                                <div class="project-counter"> 
                                    <h2 class="f-w-600 d-inline">{{ $total_pending }}</h2>
                                    Candidates
                                </div>
                                <div class="product-sub bg-primary-light">
                                    <i class="las la-users la-2x"></i>
                                </div>
                            </div>
                            @include('components.bubbles')
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
            
          </div>
        </div>
        <div class="card-footer">
          
        </div>
      </div>
    </div>
  </div>
@endsection
