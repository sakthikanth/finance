/**
 * @theme       efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var ShowBranchsClass = Class.create();
ShowBranchsClass.prototype = {
    initialize: function() {
        this.sb.attachEvents($('showbyBranch'), 'click', this.showbranchwisecat, this);
    },
    sb : new SandBox(),
    cookie : new Cookie(),

    showbranchwisecat : function (){
        var cookie = this.cookie;
        var branchChk = $('showbyBranch');
        var hostName = window.location.hostname;
        if(branchChk.checked){
            var filterbranch ="valchk";
            if (filterbranch!=null && filterbranch!="")
            {
                cookie.setCookie("filterbranch",filterbranch,1,hostName,"/");
            }
            $('category-wise').hide();
            $('branch-wise').show();

            // change text
            chkLabel = branchChk.next('.showbyBranchHolder');
            if(chkLabel){
                chkLabel.update('Show by Category');
            }
            // document.getElementById('category-wise').style.display='none';
            // document.getElementById('branch-wise').style.display='block';
        }else{
            var filterbranch=cookie.getCookie("filterbranch");
            if (filterbranch!=null && filterbranch!="")
            {
                cookie.setCookie("filterbranch",filterbranch,-1,hostName,"/");
            }
            $('branch-wise').hide();
            $('category-wise').show();

            // change text
            chkLabel = branchChk.next('.showbyBranchHolder');
            if(chkLabel){
                chkLabel.update('Show by Branch');
            }
            // document.getElementById('branch-wise').style.display='none';
            // document.getElementById('category-wise').style.display='block';          
        }               
    },
    checkCookie : function(){
        var filterbranch=this.cookie.getCookie("filterbranch");
        if (filterbranch!=null && filterbranch!="" && filterbranch=="valchk"){
            document.getElementById('showbyBranch').checked="checked";
        }
        this.showbranchwisecat();
    }
}