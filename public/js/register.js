

// 自定义函数-用来设置注册禁用或可用
var Bcaptcha=false;
const disabled = document.getElementsByClassName('is-invalid');
const btn_register = document.getElementById('btn_register');
const captcha=document.getElementById('captcha');
function bool_register() {
  if (disabled.length==0 && Bcaptcha) {
    btn_register.disabled = false;
  } else{
    btn_register.disabled = true;
  }
}

// 验证码
if(captcha){
  captcha.onblur = function () {
    if(captcha.value.length>0){
      Bcaptcha=true;
    }else{
      Bcaptcha=false;
    }
    bool_register();
  }
}
$("#captcha").bind("input propertychange change",function(event){
  //代码块
  $("#captcha").removeClass("is-invalid");

});


// 发送用户名请求
const input = document.getElementsByClassName('uname')[0];
const uname_tip = document.getElementById('uname_tip');

if (input) {
  if (input.value.length > 0) {     // 刷新页面，保留old数据时的判断
    //console.log(1)
    //1.创建对象
    const xhr = new XMLHttpRequest();

    //2.初始化 设置类型
    xhr.open('get', "http://onestore.tkk/ajax_name/" + input.value);

    //设置预定义请求头
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    //设置自定义头(需要响应头-Headers)
    //xhr.setRequestHeader('name','hzw');


    //3.发送
    xhr.send();  //请求体发送

    //4.事件绑定
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status >= 200 && xhr.status < 300) {
          //处理服务端返回结果
          if (xhr.response) {
            //console.log('未注册');
            input.classList.add("is-valid");
            input.classList.remove("is-invalid");
            uname_tip.classList.add('invalid-feedback');
            uname_tip.classList.remove('valid-feedback');

          } else {
            //console.log('已注册');
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");
            uname_tip.classList.remove('valid-feedback');
            uname_tip.classList.add('invalid-feedback');
          }
        }
      }
    }
  }

  input.onblur = function () {
    bool_register();
    //console.log(input.value.length)
    if (input.value.length > 0) {
      //console.log(1)
      //1.创建对象
      const xhr = new XMLHttpRequest();

      //2.初始化 设置类型
      xhr.open('get', "http://onestore.tkk/ajax_name/" + input.value);

      //设置预定义请求头
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

      //设置自定义头(需要响应头-Headers)
      //xhr.setRequestHeader('name','hzw');


      //3.发送
      xhr.send();  //请求体发送

      //4.事件绑定
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status >= 200 && xhr.status < 300) {
            //处理服务端返回结果
            if (xhr.response) {
              //console.log('未注册');
              input.classList.add("is-valid");
              input.classList.remove("is-invalid");
              uname_tip.classList.add('invalid-feedback');
              uname_tip.classList.remove('valid-feedback');

            } else {
              //console.log('已注册');
              input.classList.remove("is-valid");
              input.classList.add("is-invalid");
              uname_tip.classList.remove('valid-feedback');
              uname_tip.classList.add('invalid-feedback');
            }
          }
        }
      }
    } else {
      input.classList.remove("is-invalid");
      //uname_tip.classList.remove('valid-feedback');
      input.classList.remove("is-valid");

    }
  }
}


// 发送用户邮箱请求
const input_email = document.getElementsByClassName('uemail')[0];
const uemail_tip = document.getElementById('uemail_tip');
const uemail_tip2 = document.getElementById('uemail_tip2');
// 判断邮箱格式
if (input_email) {
  var reg = new RegExp("^.{6,}@qq.com$"); //正则表达式

  if (input_email.value.length > 0) {
    if (!reg.test(input_email.value)) {
      input_email.classList.remove("is-valid");
      input_email.classList.add("is-invalid");
      uemail_tip2.classList.remove('valid-feedback');
      uemail_tip2.classList.add('invalid-feedback');
      //

    } else {
      uemail_tip2.style.display = "none";
      ajax_email();
    }
  }

  input_email.onblur = function () {
    bool_register();
    if (input_email.value.length > 0) {
      if (!reg.test(input_email.value)) {
        input_email.classList.remove("is-valid");
        input_email.classList.add("is-invalid");
        uemail_tip2.classList.remove('valid-feedback');
        uemail_tip2.classList.add('invalid-feedback');
        //

      } else {
        uemail_tip2.style.display = "none";
        ajax_email();
      }
    } else {
      input_email.classList.remove("is-invalid");
      //uemail_tip2.classList.remove('valid-feedback');
      input_email.classList.remove("is-valid");
      //uemail_tip2.classList.remove('valid-feedback');
    }

  }
}

// 定义发送邮箱请求函数
function ajax_email() {

  //console.log(1)
  //1.创建对象
  const xhr = new XMLHttpRequest();

  //2.初始化 设置类型
  xhr.open('get', "http://onestore.tkk/ajax_email/" + input_email.value);

  //设置预定义请求头
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

  //设置自定义头(需要响应头-Headers)
  //xhr.setRequestHeader('name','hzw');

  if (input_email.value != '') {
    //3.发送
    xhr.send();  //请求体发送
  }

  //4.事件绑定
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status >= 200 && xhr.status < 300) {
        //处理服务端返回结果
        if (xhr.response) {
          //console.log('未注册');
          input_email.classList.add("is-valid");
          input_email.classList.remove("is-invalid");
          uemail_tip.classList.add('invalid-feedback');
          uemail_tip.classList.remove('valid-feedback');

        } else {
          //console.log('已注册');
          input_email.classList.remove("is-valid");
          input_email.classList.add("is-invalid");
          uemail_tip.classList.remove('valid-feedback');
          uemail_tip.classList.add('invalid-feedback');

        }
      }
    }
  }
}


// 判断密码长度
const input_pwd = document.getElementsByClassName('upwd')[0];
const upwd_tip = document.getElementById('upwd_tip');
if (input_pwd) {
  input_pwd.onblur = function () {
    bool_register();
    if (input_pwd.value.length < 6 && input_pwd.value.length >= 1) {
      input_pwd.classList.remove("is-valid");
      input_pwd.classList.add("is-invalid");
      upwd_tip.classList.remove('valid-feedback');
      upwd_tip.classList.add('invalid-feedback');
    } else if (input_pwd.value.length >= 6) {
      input_pwd.classList.add("is-valid");
      input_pwd.classList.remove("is-invalid");
      upwd_tip.classList.add('invalid-feedback');
      upwd_tip.classList.remove('valid-feedback');
    } else {
      input_pwd.classList.remove("is-invalid");
      //upwd_tip.classList.remove('valid-feedback');
      input_pwd.classList.remove("is-valid");
      //upwd_tip.classList.remove('valid-feedback');

    }

  }
}


// 判断确认密码
const input_pwd2 = document.getElementsByClassName('upwd2')[0];
const upwd2_tip = document.getElementById('upwd2_tip');
const upwd2_tip2 = document.getElementById('upwd2_tip2');
if (input_pwd2) {
  input_pwd2.onblur = function () {

    bool_register();
    if (input_pwd2.value.length >= 6) {
      upwd2_tip2.style.display = "none";
      if (input_pwd.value != input_pwd2.value) {
        input_pwd2.classList.remove("is-valid");
        input_pwd2.classList.add("is-invalid");
        upwd2_tip.classList.remove('valid-feedback');
        upwd2_tip.classList.add('invalid-feedback');
      } else {
        input_pwd2.classList.add("is-valid");
        input_pwd2.classList.remove("is-invalid");
        upwd2_tip.classList.add('invalid-feedback');
        upwd2_tip.classList.remove('valid-feedback');
      }
    } else if (input_pwd2.value.length > 0) {
      input_pwd2.classList.remove("is-valid");
      input_pwd2.classList.add("is-invalid");
      upwd2_tip2.classList.remove('valid-feedback');
      upwd2_tip2.classList.add('invalid-feedback');
    } else if (input_pwd2.value.length == 0) {
      input_pwd2.classList.remove("is-invalid");
      //upwd2_tip2.classList.remove('valid-feedback');
      input_pwd2.classList.remove("is-valid");
      //upwd2_tip2.classList.remove('valid-feedback');
    }

  }
}






