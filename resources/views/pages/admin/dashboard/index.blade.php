@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="card alert alert-primary" role="alert">
        <h4 class="alert-heading">Tip!</h4>
        <p>
          Add class="box-layout" attribute to get this layout. The
          boxed layout is helpful when working on large screens
          because it prevents the site from stretching very wide.
        </p>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Title</h4>
          <div class="card-header-right">
            <ul class="list-unstyled card-option">
              <li><i class="fa fa-spin fa-cog"></i></li>
              <li><i class="view-html fa fa-code"></i></li>
              <li>
                <i class="icofont icofont-maximize full-card"></i>
              </li>
              <li>
                <i class="icofont icofont-minus minimize-card"></i>
              </li>
              <li>
                <i class="icofont icofont-refresh reload-card"></i>
              </li>
              <li>
                <i class="icofont icofont-error close-card"></i>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <span>Start creating your amazing application!</span>
          <div class="code-box-copy">
            <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head" title="Copy">
              <i class="icofont icofont-copy-alt"></i>
            </button>
            <pre><code class="language-html" id="example-head">&lt;!-- Cod Box Copy begin --&gt;
&lt;div class=&quot;card-body&quot;&gt;
&lt;span&gt;Start creating your amazing application!
&lt;/span&gt;
&lt;/div&gt;
&lt;!-- Cod Box Copy end --&gt;</code></pre>
          </div>
        </div>
        <div class="card-footer">
          <h6 class="mb-0">Card Footer</h6>
        </div>
      </div>
    </div>
  </div>
@endsection
