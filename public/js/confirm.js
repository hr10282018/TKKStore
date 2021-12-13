

$(".del_goods").submit(function(e){

  $('#myModal').modal('show');

  $(".del_goods_btn .yes").click(function () {
    console.log(1)
    $('#myModal').modal('toggle')
    
    return true;
  })
  $(".del_goods_btn .no").click(function () {
    console.log(2)
    $('#myModal').modal('hide');
    return false;
  })
  return false;

});
