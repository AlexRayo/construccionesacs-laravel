
<nav class="navbar navbar-default" style="font-size: 17px">        
        <div class="container">
        <div class="navbar-header">
            <a href="#" class="btn" style="margin-top: 2px;font-size: 20px"><span class="fa fa-building"></span>Construcciones ACS</a>
        </div>
            <ul class="nav navbar-nav pull-right" style="text-align: right">
                <li><a href="/herramientas">Stock &nbsp;<span class="fa fa-briefcase"></span></a></li>
                <li><a href="/salidas">Salidas de bodega &nbsp;<span class="fa fa-external-link"></span></a></li>
                <li>
                    <div><a href="/herramientas/create" class="btn btn-primary" style="margin-top: 5px">Nuevo registro &nbsp;<span class="fa fa-file"></span></a></div>
                </li>    
                <li>
                    <div >
                        @if (Route::has('login'))
                        <div >
                        @auth
                        <!-- Authentication Links -->
                        @guest
                        @else            
                        &nbsp;&nbsp;<a class="btn btn-default" style="margin-top: 5px" title="Cerrar sesión" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            Cerrar sesión <span class="fa fa-sign-out"></span>                        
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @endguest
                            @else
                            <!-- <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>-->
                            @endauth
                    </div>
                    @endif
                </li>
            </ul>
        </div>    
    </nav>
<style>
    li{list-style: none;margin: 0 20px;}
    nav li{
    line-height: 50px;
    margin-top: 25px
    }
    .text-link{font-size: 18px;}
</style>