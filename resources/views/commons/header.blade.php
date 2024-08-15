
<!-- Page Header Start-->
<div class="page-header">
    <div class="header-wrapper row m-0">
      <form class="form-inline search-full col" action="box-layout.html#" method="get">
        <div class="form-group w-100">
          <div class="Typeahead Typeahead--twitterUsers">
            <div class="u-posRelative"> 
              <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Riho .." name="q" title="" autofocus>
              <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading... </span></div><i class="close-search" data-feather="x"></i>
            </div>
            <div class="Typeahead-menu"> </div>
          </div>
        </div>
      </form>
      <div class="header-logo-wrapper col-auto p-0">  
        <div class="logo-wrapper"> 
          <a href="#">
            <img class="img-fluid for-light" src="{!! logo() !!}" alt="logo-light">
            <img class="img-fluid for-dark" src="{!! logo() !!}" alt="logo-dark">
          </a>
        </div>
        <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
      </div>
      <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
        <div> <a class="toggle-sidebar" href="box-layout.html#"> <i class="iconly-Category icli"> </i></a>
          <div class="d-flex align-items-center gap-2 ">
            <h4 class="f-w-600">Computer Based Test (CBT)</h4>
          </div>
        </div>
        <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Community Health Practitioners Registration Board of Nigeria </span></div>
      </div>
      <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
        <ul class="nav-menus"> 
        
          <li></li>
          <li></li>
          <li> 
            <div class="mode"><i class="moon" data-feather="moon"> </i></div>
          </li>
          
          <li class="profile-nav onhover-dropdown"> 
            <div class="media profile-media"><img class="b-r-10" src="{{  tempPassport() }}" width="35" alt="">
              <div class="media-body d-xxl-block d-none box-col-none">
                <div class="d-flex align-items-center gap-2"> <span>Admin</span><i class="middle fa fa-angle-down"> </i></div>
                <p class="mb-0 font-roboto">Admin</p>
              </div>
            </div>
            <ul class="profile-dropdown onhover-show-div">
              <li><a href="#"><i data-feather="user"></i><span>My Profile</span></a></li>
              <li><a href="#"><i data-feather="mail"></i><span>Inbox</span></a></li>
              <li> <a href="#"> <i data-feather="settings"></i><span>Settings</span></a></li>
              <li><a class="btn btn-pill btn-outline-primary btn-sm" href="{{ route('auth.admin.logout') }}">Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
  
    </div>
  </div>
  <!-- Page Header Ends  