

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">

    <!-- 校徽 -->
    <img class="mr-2" src="/images/xujc.jpg" alt="" style="width: 45px; height:45px; border-radius: 50%;">
    <a class="navbar-brand " href="{{ url('') }}">
      TKK~Store
    </a>
    <ul class="navbar-nav mr-auto link_category">
      <li class="nav-item {{ active_class(if_route('home')) }} {{ search_no_category_active() }}"><a class="nav-link" href="{{ route('home') }}">全部</a></li>
      <li class="nav-item {{ category_active(1) }}"><a class="nav-link" href="{{ route('category',1) }}">学习</a></li>
      <li class="nav-item {{ category_active(2) }} "><a class="nav-link" href="{{ route('category',2) }}">生活</a></li>
      <li class="nav-item {{ category_active(3) }} "><a class="nav-link" href="{{ route('category',3) }}">娱乐</a></li>
      <li class="nav-item {{ category_active(4) }} "><a class="nav-link" href="{{ route('category',4) }}">其他</a></li>
    </ul>
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">11111</span>
    </button> -->

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav mr-auto">

      </ul>

      <!-- 右导航 -->
      <ul class="navbar-nav navbar-right col-">

        @guest
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('signup') }}">注册</a></li>

        @else
        <li class="nav-item mr-3">
          <a class="nav-link btn btn-light mt-2 mr-3 font-weight-bold" href="{{ route('create_goods') }}" style="width: 55px; height:40px;line-height:20px">
            <i class="fas fa-paper-plane" style="font-size:18px; line-height:20px"></i>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="40px" height="40px" style="border-radius: 50%;">
            <span class="ml-2"> {{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu mt-2" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" style="height: 45px; line-height:40px" href="{{ route('user_show', Auth::user()) }}">
              <i class="fas fa-user mr-2"></i>
              个人中心
            </a>

            <a class="dropdown-item" href="{{ route('user_edit', Auth::user()) }}" style="height: 45px; line-height:40px">
              <i class="fas fa-cogs mr-2"></i>
              编辑资料
            </a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('login_out') }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <!-- <input type="hidden" name="_method" value="DELETE"> -->
                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
              </form>
            </a>
          </div>
        </li>
        @endguest
      </ul>


    </div>

  </div>
</nav>


