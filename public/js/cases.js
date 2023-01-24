
$("#roulette-premium").click(function(){
    roulette.Roulette();
});
$("#roulette-vip").click(function(){
    roulette.Roulette();
});

$("#button-take").click(function() {
    roulette.TakeKey("");
});
$("#button-sell").click(function() {
    roulette.KeySellWindow();
});
$("#button-pay").click(function(){
    view.OpenWindow("#window-pay");
    view.BalanceUpdate();
    user.GetBalance();
});

$(".activate-info").click(function(){
    window.open(window.location.protocol + "//" + window.location.host + "/guarantees");
});

roulette.GetProducts();
