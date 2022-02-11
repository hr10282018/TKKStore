
// 继续添加图片
var add = document.getElementById('add');
var index = 0;
if (add) {
  $(function () {
    $("#add").click(function () {
      index++;
      var el = $(
        `<div class="input-group mb-3 border img" style="width: 800px; border-radius:5px;">
          <input class="mt-2 ml-2" type="file" name="goods_img[]" data-toggle="tooltip" data-placement="bottom" class="form-control-file  " title="请上传 (png,jpg,gif,jpeg) 格式的图片" style="margin-top:12px;width:745px;height:35px;" required />
          <div class="input-group-append">
            <button class="btn btn-outline-danger ml-1 file_`+ index + `" type="button" id="button-addon2">
            <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path style="line-height:30px" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
            </svg>
          </button>
          </div>
        </div>`);

      el.appendTo($('.more_image'));
    });

    $(".more_image ").on("click","button",function(){
      $(this).parent().parent().remove();
    })

  });

}

