
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/home" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link"></a>
    </li>
  </ul>

  <!-- SEARCH FORM -->
  <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/auth/logout" class="nav-link">Logout</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
        class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="" alt="Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
      <span class="brand-text font-weight-light">Prepareurself</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{Auth::user()->avatar}}" class="img-circle elevation-2" alt="Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Hello {{Auth::user()->first_name}} !</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="/admin/home" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                DashBoard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/users/all" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/users/all/blocked" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blocked User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview" style="display: none;">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Quizes
                <i class="right fas fa-angle-left"></i>
                <span class="badge badge-info right">4</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/quiz/create" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/quiz/all" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Quizes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/quiz/all/pending" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Quizes</p>
                  <span class="badge badge-info right">4</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/quiz/all/previous" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Previous Quizes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Questions Bank
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/question/create" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/question/all" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Questions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/question/all/easy" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Easy Questions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/question/all/medium" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Medium Questions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/question/all/hard" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hard questions</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Courses
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/course/create" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/course/all" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/course/all/published" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Published Courses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/course/all/unpublished" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Un-Published Course</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Topics
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/topic/create" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/topic/all" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Topics</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Projects
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/project/create" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/project/all" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Projects</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item">
            <a href="/admin/resource/all" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Resources
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/email" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Send Email
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/notification/show" class="nav-link">
              <i class="nav-icon fab fa-android"></i>
              <p>
                Android Notification
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="/admin/banner/show" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Banner
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="/admin/gallery/show" class="nav-link">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
             <li class="nav-item">
            <a href="/admin/users/feedback" class="nav-link">
              <i class="nav-icon far fa-comment-dots"></i>
              <p>
                User Feedback
              </p>
            </a>
          </li>
          @if(Auth::user()->super)
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage CMS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.manage')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Admin</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
