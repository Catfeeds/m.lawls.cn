// js动态加载表情
if (showZan=='') showZan=3;
if (comment_tips=='') comment_tips='说点什么吧';
if (show_floor=='') show_floor='1';
if (showQQ=='') showQQ='1';
if (showQQ=='2'){
    jDedemao(".ds-add-emote").hide();
}
if (comment_ipaddr=='') comment_ipaddr='1';
tuzkiNumber = 1;
function getTuzki(obj) {
    var tuzkiObj = jDedemao(obj).siblings('.b-tuzki');
    if (tuzkiNumber) {
        jDedemao(".b-box-textarea").addClass("marginB210");
        tuzkiObj.show();
        var title = ['微笑', '撇嘴', '色', '发呆', '酷', '流泪', '害羞', ',闭嘴', '大哭', '尴尬', '发怒', '调皮', '龇牙', '惊讶', '难过', '冷汗', '抓狂', '吐', '偷笑', '可爱', '白眼', '傲慢', '饥饿', '困', '惊恐', '流汗', '憨笑', '大兵', '奋斗', '咒骂', '疑问', '嘘', '晕', '折磨', '衰', '骷髅', '敲打', '再见', '擦汗', '抠鼻', '鼓掌', '糗大了', '坏笑', '左哼哼', '右哼哼', '哈欠', '鄙视', '委屈', '快哭了', '阴险', '亲亲', '吓', '可怜', '菜刀', '西瓜', '啤酒', '篮球', '乒乓', '拥抱', '强', '弱', '握手', '胜利', '抱拳', '敬礼', '眼保健操', '念经', '流鼻血', '全方位鄙视', '挥泪说再见', '狂流鼻血', '撇嘴', '偷笑', '流汗', '可爱', '搞怪', '发呆', '乱亲', '懵逼', '斜视', '抽着烟微笑', '微笑抠鼻孔', '坏笑'];
        var alt = ['wx', 'pz', 'se', 'fd', 'ku', 'll', 'hx', 'bz', 'dk', 'gg', 'fl', 'tp', 'cy', 'jingkong', 'ng', 'lh', 'zk', 'tu', 'tx', 'ka', 'by', 'am', 'je', 'kun', 'jk', 'lh', 'hanxiao', 'db', 'fd', 'zm', 'yw', 'xu', 'yun', 'zm', 'shuai', 'kl', 'qd', 'zj', 'ch', 'kb', 'gz', 'qdl', 'hx', 'zhh', 'yhh', 'hq', 'bs', 'wq', 'kkl', 'yx', 'qq', 'xia', 'kl', 'cd', 'xg', 'pj', 'lq', 'pp', 'yb', 'qiang', 'ruo', 'ws', 'sl', 'bq', 'jl', 'ybjc', 'nj', 'lbx', 'qfwbs', 'hlszj', 'klbx', 'bz2', 'tx2', 'lh2', 'ka2', 'gg2', 'fd2', 'luanqin', 'mb', 'xieshi', 'cywx', 'wxkbk', 'huaixiao2'];
        var str = '';
        for (var i = 0; i < alt.length; i++) {
            str += '<img src="'+PLUS_URL+'/dedemao-comment/face/' + alt[i] + '.gif" title="' + title[i] + '">';
        }
        tuzkiObj.html(str);
        tuzkiNumber = 0;
    } else {
        jDedemao(".b-box-textarea").removeClass("marginB210");
        tuzkiObj.hide();
        tuzkiNumber = 1;
    }
}

/**
 * 格式化数字为一个定长的字符串，前面补0
 * @param  int Source 待格式化的字符串
 * @param  int Length 需要得到的字符串的长度
 * @return int        处理后得到的数据
 */
function formatNum(Source, Length) {
    var strTemp = "";
    for (i = 1; i <= Length - Source.toString().length; i++) {
        strTemp += "0";
    }
    return strTemp + Source;
}

// 点击添加表情
jDedemao(document).on('click', '.b-tuzki img', function (event) {
    var str = jDedemao(this).prop("outerHTML");
    jDedemao(this).parents('.b-box-textarea').eq(0).find('.b-box-content').focus();
    jDedemao(this).parents('.b-box-textarea').eq(0).find('.b-box-content').append(str);
    jDedemao(this).parents('.b-tuzki').hide();
    jDedemao(".b-box-textarea").removeClass("marginB210");
    tuzkiNumber = 1;
});

/**
 * 在textarea光标后插入内容
 * @param  string  str 需要插入的内容
 */
function insertHtmlAtCaret(str) {
    var sel, range;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            var el = document.createElement("div");
            el.innerHTML = str;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ((node = el.firstChild)) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        document.selection.createRange().pasteHTML(str);
    }
}

// 发布评论
function comment(obj) {
    var url = PLUS_URL+'/comment_ajax.php';
    var content = jDedemao(obj).parents('.b-box-textarea').eq(0).find('.b-box-content').html();
    if (content != '' && content != '说点什么吧') {
        var aid = jDedemao(obj).attr('aid'),
            pid = jDedemao(obj).attr('pid'),
            email = jDedemao(obj).parents('.b-box-textarea').eq(0).find("input[name='email']").val(),
            postData = {
                "dopost": 'send',
                "aid": aid,
                "pid": pid,
                'content': content,
                'email': email
            };
        // 显示loading
        jDedemao(".comment-load").show();
        // ajax评论
        jDedemao.post(url, postData, function (data) {
            var data = eval('(' + data + ')');
            if (data.code > 0) {
                var newPid = data.code;
                var replyName = jDedemao(obj).attr('username');
                var now = new Date();
                // 获取当前时间
                var date = now.getFullYear() + "-" + ((now.getMonth() + 1) < 10 ? "0" : "") + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? "0" : "") + now.getDate() + '&emsp;' + (now.getHours() < 10 ? "0" : "") + now.getHours() + ':' + (now.getMinutes() < 10 ? "0" : "") + now.getMinutes() + ':' + (now.getSeconds() < 10 ? "0" : "") + now.getSeconds();
                var headImg = data.headpic;
                var nickName = data.nickName;
                if (pid == 0) {
                    // pid为0表示新增评论
                    var floorHtml = show_floor==1 ? '<strong class="p_floor">'+data.floor+'楼</strong>' : '';
                    var ipinfo = comment_ipaddr==1 ? data.ipinfo + '网友' : '';
                    var str = '<li class="entry"><div class="adiv"><div><img class="headerimage" src="' + headImg + '"></div></div><div><div class="info rmp">'+floorHtml+'<div class="nmp"><span class="nick">'+nickName+'</span><span class="posandtime">' + ipinfo + '&nbsp;'+data.date+'</span></div></div><div class="comm"><p>'+data.content+'</p></div><div class="zhiChi"><span class="comm_reply">';
                    if (showZan==3 || showZan==1){
                        str+='<a class="s" href="javascript:commentVote(\'goodfb\','+data.code+')">支持(0)</a>';
                    }
                    if (showZan==3 || showZan==2){
                        str+='<a class="a" href="javascript:commentVote(\'badfb\','+data.code+')">反对(0)</a>';
                    }
                    str+='<a href="javascript:;" aid="'+aid+'" pid="'+newPid+'" username="'+nickName+'" onclick="reply(this)">回复</a></span></div></div></li>';
                    jDedemao('#ulcommentlist').prepend(str);
                } else {
                    // pid不为0表示是回复评论
                    var ipinfo = comment_ipaddr==1 ? data.ipinfo + '网友' : '';
                    var str = '<li class="gh"><div class="adiv"><div><img class="headerimage"  src="'+headImg+'"></a></div></div><div><div class="re_info rmp rmpvipblue"><strong class="p_floor">2#</strong><div class="nmp"><span class="nick">'+nickName+'</span><span class="posandtime">'+ipinfo+'&nbsp;'+data.date+'</span></div></div><div class="re_comm"><p>'+data.content+'</p><div class="zhiChi"><span class="comm_reply">';
                    if (showZan==3 || showZan==1){
                        str+='<a class="s" href="javascript:commentVote(\'goodfb\','+data.code+')">支持(0)</a>';
                    }
                    if (showZan==3 || showZan==2){
                        str+='<a class="a" href="javascript:commentVote(\'badfb\','+data.code+')">反对(0)</a>';
                    }
                    str+='<a href="javascript:;" aid="'+aid+'" pid="'+newPid+'" username="'+nickName+'" onclick="reply(this)">回复</a></span></div></div></div></li>';
                    if(jDedemao(obj).parents('.entry').eq(0).find('.reply').length==0){
                        jDedemao("<ul class=\"reply\">"+str+"</ul>").appendTo(jDedemao(obj).parents('.entry').eq(0));
                    }else{
                        jDedemao(obj).parents('.entry').eq(0).find('.reply').append(str);
                    }
                    jDedemao(obj).parents('.b-box-textarea').eq(0).remove();
                }
                jDedemao(obj).parents('.b-box-textarea').eq(0).find('.b-box-content').html('');
                // 关闭loading
                jDedemao(".comment-load").hide();
                jDedemao(".empty-prompt-w").remove();
                jDedemao(obj).parents('.b-box-textarea').eq(0).find('.error-tip').hide();
                jDedemao("#comment-parents").text(jDedemao("#comment-count").text() - 0 + 1);
            } else {
                jDedemao(".comment-load").hide();
                // jDedemao(".error-tip").html(data.data);
                jDedemao(obj).parents('.b-box-textarea').eq(0).find('.error-tip').html(data.data);
                jDedemao(obj).parents('.b-box-textarea').eq(0).find('.error-tip').show();
            }

        });
    } else {
        jDedemao(obj).parents('.b-box-textarea').eq(0).find('.error-tip').text('请填写评论内容');
        jDedemao(obj).parents('.b-box-textarea').eq(0).find('.error-tip').show();
    }
}

// 回复评论
function reply(obj) {
    var boxTextarea = jDedemao(obj).parents(".zhiChi").eq(0).find(".b-box-textarea");
    if (boxTextarea.length == 1) {
        boxTextarea.remove();
    }else{
        var aid = jDedemao(obj).attr('aid');
        var pid = jDedemao(obj).attr('pid');
        var username = jDedemao(obj).attr('username');
        var emoteHtml = '';
        if (showQQ=='1'){
            emoteHtml='<a class="ds-toolbar-button ds-add-emote" title="插入表情" onclick="getTuzki(this)"></a>';
        }
        var str = '<div class="b-box-textarea"><div class="b-box-textarea-body"><div class="b-box-content" contenteditable="true" onfocus="delete_hint(this)">'+comment_tips+'</div><ul class="b-emote-submit"><li class="b-emote">'+emoteHtml+'<input class="b-email" type="text" name="email" placeholder="接收回复的email地址" value=""><div class="b-tuzki"></div></li><li class="b-submit-button"><input type="button" value="评 论" aid="' + aid + '" pid="' + pid + '" username="' + username + '" onclick="comment(this)"></li><li class="b-clear-float"></li></ul></div><div class="error-tip"></div></div>';
        var parentObj = jDedemao(obj).parents('.zhiChi').eq(0).append(str);
    }
}

// 删除提示和样式
function delete_hint(obj) {
    var word = jDedemao(obj).text();
    if (word == comment_tips) {
        jDedemao(obj).text('');
        jDedemao(obj).css('color', '#333');
    }
}

function get_ajax_comment(aid, start, limit,orderWay,type) {
    var url = PLUS_URL+"/comment_ajax.php";
    var param = {dopost:'getlist',aid: aid, start: start, limit: limit,orderWay:orderWay};
    jDedemao.getJSON(url, param, function (data) {
        jDedemao(".comment-load").hide();
        if(data.count) jDedemao(".comment-count").text(data.count);
        if (data.html) jDedemao(".empty-prompt-w").remove();
        if (type=='refresh'){
            jDedemao("#ulcommentlist").html(data.html);
        }else{
            jDedemao("#ulcommentlist").append(data.html);
        }
        jDedemao(".section-page-w").html(data.page);
    });
}

//获取cookie
function getCookieValue(cookieName) {
    var cookieValue = document.cookie;
    var cookieStartAt = cookieValue.indexOf("" + cookieName + "=");
    if (cookieStartAt == -1) {
        cookieStartAt = cookieValue.indexOf(cookieName + "=");
    }
    if (cookieStartAt == -1) {
        cookieValue = null;
    }
    else {
        cookieStartAt = cookieValue.indexOf("=", cookieStartAt) + 1;
        cookieEndAt = cookieValue.indexOf(";", cookieStartAt);
        if (cookieEndAt == -1) {
            cookieEndAt = cookieValue.length;
        }
        cookieValue = unescape(cookieValue.substring(cookieStartAt, cookieEndAt));//解码latin-1
    }
    return cookieValue;
}

function commentVote(ftype,fid)
{

    var taget_obj = jDedemao('#'+ftype+fid);
    var saveid = GetCookie('badgoodid');
    if(saveid != null)
    {
        var saveids = saveid.split(',');
        var hasid = false;
        saveid = '';
        j = 1;
        for(i=saveids.length-1;i>=0;i--)
        {
            if(saveids[i]==fid && hasid) continue;
            else {
                if(saveids[i]==fid && !hasid) hasid = true;
                saveid += (saveid=='' ? saveids[i] : ','+saveids[i]);
                j++;
                if(j==10 && hasid) break;
                if(j==9 && !hasid) break;
            }
        }
        if(hasid) { alert('您刚才已表决过了喔！'); return false; }
        else saveid += ','+fid;
        SetCookie('badgoodid',saveid,1);
    }
    else
    {
        SetCookie('badgoodid',fid,1);
    }
    jDedemao.post(PLUS_URL+'/comment_ajax.php',{action:ftype,fid:fid},function (data) {
        if (data.code==0){
            taget_obj.text(data.data);
        }
    },'json');
}

//读写cookie函数
function GetCookie(c_name)
{
    if (document.cookie.length > 0)
    {
        c_start = document.cookie.indexOf(c_name + "=")
        if (c_start != -1)
        {
            c_start = c_start + c_name.length + 1;
            c_end   = document.cookie.indexOf(";",c_start);
            if (c_end == -1)
            {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return null
}

function SetCookie(c_name,value,expiredays)
{
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}
function getHeadPic() {
    var url =PLUS_URL+'/comment_ajax.php';
    jDedemao.getJSON(url,{action:'getHeadPic'},function (data) {
        if (data.code==0){
            jDedemao(".dedemao-comment .b-head-img").attr('src',data.data);
            jDedemao(".dedemao-comment .b-email").hide();
        }
    });
}