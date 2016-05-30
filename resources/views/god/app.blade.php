<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="author" content="staraw">
  <meta name="description" content="世达奥科">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>微脉事WeMesh&trade;</title>
  <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="//cdn.bootcss.com/jquery.perfect-scrollbar/0.6.10/css/perfect-scrollbar.min.css" rel="stylesheet">
  <link href="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>
<!--[if lt IE 10]>
<p class="browserupgrade">您的浏览器已<strong>面临淘汰</strong>,到这里<a href="http://www.stario.net/bye.html/">升级靠谱浏览器</a>提升安全及体验。</p>
<![endif]-->
<div id="box" class="app-sidebar-fixed app-navbar-fixed ">
    <div class="sidebar app-aside hidden-print " id="sidebar" >
    <div class="sidebar-container" id="sidebox">
      <!-- start: SEARCH FORM -->
      <div class="search-form hidden-md hidden-lg">
        <form class="navbar-form" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="搜索关键字...">
            <button class="btn search-button" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </form>
      </div>
      <!-- end: SEARCH FORM -->
      <!-- start: USER OPTIONS -->
      <user-info></user-info>
      <!-- end: USER OPTIONS -->
      <!-- start: SIDEBAR -->
      <nav id="sidemenu">
        <sidemenu></sidemenu>
      </nav>
      <!-- end: SIDEBAR -->
    </div>
  </div>
    <div class="app-content">
        <!-- top navbar -->
         <header class="navbar navbar-default navbar-static-top hidden-print">
    <!-- start: NAVBAR HEADER -->
    <div class="navbar-header">
        <button  class="menu-mobile-toggler btn pull-left hidden-md hidden-lg" id="horizontal-menu-toggler" >
            <i class="fa fa-bars"></i>
        </button>
        <button   class="sidebar-mobile-toggler btn pull-left hidden-md hidden-lg" v-on:click="toggleSidebar">
            <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="/"> <img width="32px" src="http://7lrzqf.com1.z0.glb.clouddn.com/images/ucenter-logo.png" alt="WeStar" />微脉事 WeMesh &trade;</a>
<!--         <a class="navbar-brand navbar-brand-collapsed" href="/"> <img width="32px" src="http://7lrzqf.com1.z0.glb.clouddn.com/images/ucenter-logo.png" alt="WeStar" />微脉事 WeMesh &trade;</a> -->
                <button class="btn pull-right menu-toggler  visible-xs-block" id="menu-toggler" v-on:click="navbarCollapsed" >
            <i v-bind:class="isNavbarCollapsed ? 'fa fa-folder-open' : 'fa fa-folder'"></i> <small><i class="fa fa-caret-down margin-left-5"></i></small>         
        </button>
    </div>
    <!-- end: NAVBAR HEADER -->
    <!-- start: NAVBAR COLLAPSE -->
    <div class="navbar-collapse collapse" id="navbar-collapse">
        <ul class="nav navbar-left hidden-sm hidden-xs">
            <li>
                <fullscreen></fullscreen> 
            </li>
            <li>
                <form role="search" class="navbar-form main-search">
                    <div class="form-group">
                        <input type="text" placeholder="搜索关键字..." class="form-control">
                        <button class="btn search-button" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="nav navbar-right">
            <!-- start: MESSAGES DROPDOWN -->    
            <dropdown class="dropdown">
        <a class=" dropdown-toggle" type="button"  data-toggle="dropdown"  v-on:click="toggleMsg">
            <i class="fa fa-wechat"></i> 
        </a>
           <msg-box  api="http://demo1429768.mockable.io/messages"></msg-box>   
           </dropdown>  
            <!-- end: MESSAGES DROPDOWN -->
        </ul>
        <!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
        <div class="close-handle visible-xs-block menu-toggler" v-on:click="navbarCollapsed">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
        <!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
    </div>
    <button v-on:click="toggleChatBox" class="sidebar-mobile-toggler dropdown-off-sidebar btn hidden-md hidden-lg">
        <i class="fa" v-bind:class="isChatBoxOn ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
    </button>

    <button v-on:click="toggleChatBox" class="dropdown-off-sidebar btn hidden-sm hidden-xs">
        <i class="fa" v-bind:class="isChatBoxOn ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
    </button>
    <!-- end: NAVBAR COLLAPSE -->
</header>
<!-- end: TOP NAVBAR -->
        <!-- main content -->
        <div  class="main-content">
          <div class="wrap-content container">
                <breadcrumb></breadcrumb>
                @yield('content')
          </div>
        </div>
        <!-- / main content -->
      </div>
      <!-- footer -->
      <footer data-ng-include=" 'assets/views/partials/footer.html' " class="hidden-print"></footer>
      <!-- / footer -->
       <chatbox api="http://demo1429768.mockable.io/messages"></chatbox>
</div>
<script src="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{asset('js/god.js')}}"></script>
</body>

</html>
