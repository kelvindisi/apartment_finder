<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    @if(Auth::user()->userlevel=='admin')
      <?php $url="/admin" ?>
    @elseif(Auth::user()->userlevel=='landlord')
      <?php $url="/landlord" ?>
    @elseif(Auth::user()->userlevel=='user')
      <?php $url="/user" ?>
    @else
      <?php $url="/" ?>
    @endif
    <a class="navbar-brand" href="{{$url}}">
      @if(Auth::user()->userlevel=='admin')
       {{_('Admin')}}
      @elseif(Auth::user()->userlevel=='landlord')
        {{_('Landlord')}}
      @elseif(Auth::user()->userlevel=='user')
        {{_('Apartment finder')}}
      @endif
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      @if(Auth::user()->userlevel=='admin')
      @include('admin.navbar')
      @elseif(Auth::user()->userlevel=='landlord')
      @include('landlord.navbar')
      @elseif(Auth::user()->userlevel=='user')
      @include('users.navbar')
      @endif

      <ul class="navbar-nav" style="margin-left: auto;">
        <li class="nav-item">
          <a href="{{route('logout')}}" class="nav-link">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>