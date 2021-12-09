<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>注册确认链接</title>
</head>

<body>
  <h1>感谢您在 TKK Store 平台进行注册！</h1>

  <p>
    请点击下面的按钮完成注册：
    <a href="{{ route('signup_verify', $user->activation_token) }}" class="button button-primary" target="_blank" rel="noopener" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">
      验证 E-mail
    </a>
  </p>

  <p>
    如果这不是您本人的操作，请忽略此邮件。
  </p>
</body>

</html>
