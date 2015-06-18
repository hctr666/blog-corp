<div class="header">

    <ul class="nav nav-pills pull-right">

        @if ($currentUser)
            <li class="active"><a href="{{ route('posts.create') }}"><i class="fa fa-pencil-square-o"></i> {{ lang('Nuevo Post') }}</a></li>

            <li class="dropdown">
              <a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" href="#">
                <i class="fa fa-user"></i> {{ $currentUser->display_name }}
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                @if ($currentUser->can("manage_contents"))
                    <li><a href="{{ URL::to('admin') }}"><i class="fa fa-tachometer"></i> {{ lang('Panel administrador') }}</a></li>
                @endif

                <li><a href="{{ route('users.settings') }}"><i class="fa fa-cog"></i> {{ lang('Mi perfil') }}</a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> {{ lang('Salir') }}</a></li>
              </ul>
            </li>

        @else
            <li ><a href="{{ route('signup') }}">{{ lang('Registrarse') }}</a></li>
            <li class="active"><a href="{{ route('login') }}">{{ lang('Ingresar') }}</a></li>
        @endif
    </ul>

    <a href="{{ route('home') }}">
        <h2 class="text-muted brand"></h2>
        {{ HTML::image('assets/images/blog-logo.png'); }}
    </a>

</div>
