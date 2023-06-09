  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{URL_BASE}}dashboard" class="brand-link">
      <img src="{{$this->asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image text-center">
          @if ($this->getSession("foto") != null)
              @php $Foto ='fotos/'.$this->getSession("foto"); @endphp

              @else:
               @php $Foto ='dist/img/user2-160x160.jpg'; @endphp
          @endif
      
          <img src="{{$this->asset($Foto)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            @if ($this->existSession("username_"))
                 {{$this->getSession("username_")}}
            @endif
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
           
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

          @if($this->autorizado("Modulo.index"))
          <li class="nav-item">
            <a href="{{URL_BASE}}module" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Module
              </p>
            </a>
          </li>
          @endif

          @if($this->autorizado("Usuario.index"))

          <li class="nav-item">
            <a href="{{URL_BASE}}usuario" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuario
              </p>
            </a>
          </li>
          @endif

          @if($this->autorizado("Rol.index"))
          <li class="nav-item">
            <a href="{{URL_BASE}}role" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Roles
              </p>
            </a>
          </li>
          @endif

          @if($this->autorizado("Config.copia") || $this->autorizado("Config.restaurar"))
          <li class="nav-item">
            <a href="{{URL_BASE}}database" class="nav-link">
              <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
              <p>
                configuración
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item" onclick="document.getElementById('Form-logout').submit()">
            <a href="javascript:;" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Salir
              </p>
            </a>

            <form action="{{URL_BASE}}login/logout" method="post" id="Form-logout" class="d-none"></form>
          </li>

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>