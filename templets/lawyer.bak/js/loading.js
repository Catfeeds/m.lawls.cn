// $(function(){
//     var liHeight=$('.proList li').outerHeight(true);
//     var count=$('.proList li').length;
//     var dheight=$('.proList').outerHeight();
//     var allheight = (Math.ceil(count/5))*liHeight;
//     var n=1;
//     $('.more').click(function(){
//         n++;
//         h=dheight*n;
//         if(h >= allheight){
//             h = allheight;
//             $('.more').html('没有更多了');
//         }
//         $('.proList').height(h);
//     });
// });

// var liHeight=$('.proList li').outerHeight(true);
// var count=$('.proList li').length;
// var dheight=$('.proList').outerHeight();
// var n=1;
// var allheight = (Math.ceil(count/5))*liHeight;

function loadData()
{
    var dd = $(document).height();
    var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());

    if (dd <= totalheight)
    {
        n++;
        dd=dheight*n;
        if(dd > allheight){
            dd = allheight;
            $('.more').html('没有更多了');
        }
        $('.proList').height(dd);
    }
}
$(window).scroll( function() {
    loadData();
});