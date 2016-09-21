/**
 * Created by ly on 16/9/18.
 */
;(function () {
//    a ajax处理
});
//ajax处理
//ajax新增
function ajaxAdd(url,mtdata,nextUrl) {
    $.post(url,mtdata,function (data) {
        if(data.status=='true'){
            bootbox.alert(data.result,function () {
                if(nextUrl==''){
                    window.location.reload();
                }else{
                    window.location.replace(nextUrl);
                }
            });
        }else {
            bootbox.alert(data.result);
        }
    });
}
//编辑
function ajaxEdit(url,mtdata,nextUrl) {
    $.post(url,mtdata,function (data) {
        if(data.status=='true'){
            bootbox.alert(data.result,function () {
                if(nextUrl==''){
                    window.location.reload();
                }else{
                    window.location.replace(nextUrl);
                }
            });
        }else {
            bootbox.alert(data.result);
        }
    });
}
//删除
function ajaxDel(url,mtdata) {
    bootbox.confirm('确定删除吗',function (result) {
        if(result){
            $.post(url,mtdata,function (data) {
                if(data.status=='true'){
                    bootbox.alert(data.result,function () {
                        window.location.reload();
                    });
                }else {
                    bootbox.alert(data.result);
                }
            });
        }
    });
}