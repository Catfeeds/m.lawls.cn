<li [field:global runphp='yes' name=autoindex]if(@me%2==0) @me="style='float:right'" ; else @me ="" ;[/field:global]>
                <div>
                    <h3>最新评价</h3>
                    <p class="wx"><img src="/templets/lawyer/images/wuxing.png" alt=""></p>
                </div>
                <p><span>[field:dtime function="MyDate('Y-m-d H:i',@me)"/] * 用户 [field:username function="cutPhone(@me)"/]：</span></p>
                <p>[field:msg/]</p>
                <p><span>法易通</span>回复：[field:reply/]</p>
            </li>