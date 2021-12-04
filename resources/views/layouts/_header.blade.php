<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <!-- 校徽 -->
    <img class="mr-2" src="/images/xujc.jpg" alt="" style="width: 45px; height:45px; border-radius: 50%;" >
    <a class="navbar-brand " href="{{ url('') }}">
      TKK
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- 左导航 -->
      <ul class="navbar-nav mr-auto">
      </ul>

      <!-- 右导航 -->
      <ul class="navbar-nav navbar-right">

        <li class="nav-item"><a class="nav-link" href="">登录</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('signup') }}">注册</a></li>
      </ul>


    </div>
  </div>
</nav>
