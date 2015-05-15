;(function($){
    $(function(){
        $(".sub_btn").on("click",function(){
            var account=$(".account").val();
            var password=$(".password").val();
            if(account==""){
                alert("请输入您的帐号！");
                return false;
            }
            if(password==""){
                alert("请输入您的密码！");           
                return false;
            }
            if(account=="admin"&&password=="lv2015"){
                location.href="upload.html";
            }
            else{
                alert("账号或密码有误，请重新填写！");
                $(".account").val("");
                $(".password").val("");

            }

        });
        $(".upload_btn").on("click",function(){
            var code=$(".code").val();
            if(code==""){
                alert("请输入您的编号！");
                return false;
            }

        });
        
  
    })
})(jQuery)


