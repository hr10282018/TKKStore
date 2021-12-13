<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php
  $a="http1,http2,";
  $b=array();
  $b=explode(',',$a);
  print_r($b);

?>


<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
// $(function() {
//     $(".x button").click(function () {
//       alert($(this)['index'])

//     })

//     var liList = $(".x button");
//     for (var i = 0; i < liList.length; i++) {
//         //  1.使用闭包
//         liList[i].onclick = (function () {
//             var index = i;
//             // 返回了一个匿名函数
//             return function () {
//                 alert('我的索引是:' + index);
//             };
//         }())
//     }

// })
</script>
</body>
</html>
