var countdown = 5000;
setTimeout(Loop(), countdown);

function Loop()
{
    setInterval(function(){
        countdown-=1000;
        $("#countdown").text(countdown/1000);
        if(countdown/1000 < 1){
            window.location.replace("index.php");
        }
    }, 1000);
}