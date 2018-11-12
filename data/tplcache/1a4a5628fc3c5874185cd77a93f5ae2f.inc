<li>
                <div>
                    <h3>最新评价</h3>
                    <p class="wx"><img src="/templets/lawyer/images/wuxing.png" alt=""></p>
                </div>
                <p><span>[field:dtime function="MyDate('Y-m-d H:i',@me)"/] * 用户 [field:username function="（@me=='guest' ? '游客' : @me）"/]：</span>[field:msg/]</p>
                {dede:sql sql="SELECT a.msg FROM dede_feedback a where ischeck=1 and aid=pid ORDER BY aid DESC LIMIT 0 , 1"}
                <p><span>管理员：</span>能帮到您是最好的。祝福您万事如意。</p>
                {/dede:sql}
            </li>