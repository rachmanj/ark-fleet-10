<nav class="main-header navbar navbar-expand navbar-dark">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" id="darkModeToggle" href="#" role="button" title="Toggle Dark Mode">
        <i class="fas fa-moon"></i>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a id="dropdownPayreq" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><strong>{{ auth()->user()->name }}</strong></a>
      <ul aria-labelledby="dropdownPayreq" class="dropdown-menu border-0 shadow">
        <li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>